// src/models/personaModel.js
const API_URL = "http://localhost:8080/api/persona";

export const PersonaModel = {
  async listar() {
    const res = await fetch(API_URL);
    if (!res.ok) throw new Error("Error al listar personas");
    return await res.json();
  },

  async eliminar(id) {
    const res = await fetch(`${API_URL}/${id}`, { method: "DELETE" });
    if (!res.ok) throw new Error("Error al eliminar persona");
    return true;
  },
};
