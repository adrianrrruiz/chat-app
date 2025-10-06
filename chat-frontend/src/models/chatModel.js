const API_URL = "http://localhost:8080/api/chat";

export const ChatModel = {
  async listar() {
    const res = await fetch(API_URL);
    if (!res.ok) throw new Error("Error al listar chats");
    return res.json();
  },

  async crear(data) {
    const res = await fetch(API_URL, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    });
    if (!res.ok) throw new Error("Error al crear chat");
    return res.json();
  },

  async actualizar(id, data) {
    const res = await fetch(`${API_URL}/${id}`, {
      method: "PUT",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    });
    if (!res.ok) throw new Error("Error al actualizar chat");
    return res.json();
  },

  async eliminar(id) {
    const res = await fetch(`${API_URL}/${id}`, { method: "DELETE" });
    if (!res.ok) throw new Error("Error al eliminar chat");
    return true;
  },
};
