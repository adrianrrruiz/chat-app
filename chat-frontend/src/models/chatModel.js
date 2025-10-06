// src/models/personaModel.js
const API_URL = "http://localhost:8080/api/chat";

export const ChatModel = {
  async listar() {
    const res = await fetch(API_URL);
    if (!res.ok) throw new Error("Error al listar chats");
    return await res.json();
  },

  async eliminar(id) {
    const res = await fetch(`${API_URL}/${id}`, { method: "DELETE" });
    if (!res.ok) throw new Error("Error al eliminar chat");
    return true;
  },
};
