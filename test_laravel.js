async function test() {
    try {
        const res = await fetch('http://localhost:8000/api/register', {
            method: 'POST',
            body: JSON.stringify({
                name: 'John Doe',
                phone: '1234567890',
                flat: 'A-101',
                purpose: 'Meeting'
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
