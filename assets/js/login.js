function login(token) {
    token = JSON.parse(atob(token))
    for (const [key, value] of Object.entries(token)) {
        const encodedKey = encodeURIComponent(key);
        const encodedValue = encodeURIComponent(value);
        document.cookie = `${encodedKey}=${encodedValue}; path=/;`;
    }
}