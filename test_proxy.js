async function test() {
    process.env['NODE_TLS_REJECT_UNAUTHORIZED'] = '0';
    try {
        const res = await fetch('https://localhost:5173/api/register', {
            method: 'POST',
            body: JSON.stringify({
                name: 'Test Visitor',
                phone: '1234567890',
                flat: 'A-202',
                purpose: 'Delivery'
            }),
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' }
        });
        const json = await res.json();
        console.log("Status:", res.status);
        console.log("Response:", json);
    } catch (e) {
        console.error("Error:", e);
    }
}
test();
