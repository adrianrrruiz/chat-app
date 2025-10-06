export let user = $state({ id: null, telefono: null });

export async function loginUser(telefono) {
  const res = await fetch("http://localhost:8080/api/persona", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ telefono }),
  });
  const data = await res.json();
  user.id = data.id;
  user.telefono = data.telefono;
}