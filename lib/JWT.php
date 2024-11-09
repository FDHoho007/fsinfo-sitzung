<?php

function base64_url_encode($data): string
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64_url_decode($data): false|string
{
    return base64_decode(strtr($data, '-_', '+/'));
}

class JWT
{

    const DEFAULT_HEADER = ["alg" => "HS256", "typ" => "JWT"];

    public function __construct(private array $header, private array $payload)
    {
    }

    public static function verify(string $jwt, string $signingKey = JWT_SECRET_KEY): bool
    {
        $jwt = explode(".", $jwt);
        if (count($jwt) !== 3)
            return false;
        $signature = base64_encode(hash_hmac("sha256", $jwt[0] . "." . $jwt[1], $signingKey, true));
        return hash_equals($signature, $jwt[2]);
    }

    public static function parse(string $jwt): ?JWT
    {
        $jwt = explode(".", $jwt);
        if (count($jwt) !== 3)
            return null;
        $header = json_decode(base64_url_decode($jwt[0]), true);
        $payload = json_decode(base64_url_decode($jwt[1]), true);
        return new JWT($header, $payload);
    }

    public function getHeader(): array
    {
        return $this->header;
    }

    public function setHeader(array $header): void
    {
        $this->header = $header;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function setPayload(array $payload): void
    {
        $this->payload = $payload;
    }

    public function sign(string $signingKey = JWT_SECRET_KEY): string
    {
        $header = base64_url_encode(json_encode($this->header));
        $payload = base64_url_encode(json_encode($this->payload));
        return "$header.$payload." . base64_encode(hash_hmac("sha256", "$header.$payload", $signingKey, true));
    }

}