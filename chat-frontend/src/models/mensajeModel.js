// src/models/personaModel.js
const API_URL = "http://localhost:8080/api/mensaje";

export const MensajeModel = {
  async listar() {
    const res = await fetch(API_URL);
    if (!res.ok) throw new Error("Error al listar mensajes");
    return await res.json();
  },

  async eliminar(id) {
    const res = await fetch(`${API_URL}/${id}`, { method: "DELETE" });
    if (!res.ok) throw new Error("Error al eliminar mensaje");
    return true;
  },
};
