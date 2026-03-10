async function test() {
    process.env['NODE_TLS_REJECT_UNAUTHORIZED'] = '0';
    try {
        const id = '386364e831799bbb'; // ID returned from previous test
        const res = await fetch(`https://localhost:5173/api/approve/${id}`, {
            method: 'POST',
            body: JSON.stringify({}),
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
