// src/controllers/personaController.js
import { PersonaModel } from "../models/personaModel.js";

export const PersonaController = {
  async listar(callback) {
    try {
      const data = await PersonaModel.listar();
      callback(data);
    } catch (err) {
      console.error(err);
      alert("No se pudieron cargar las personas");
    }
  },

  async eliminar(id, reloadCallback) {
    try {
      if (confirm("¿Eliminar esta persona?")) {
        await PersonaModel.eliminar(id);
        reloadCallback();
      }
    } catch (err) {
      console.error(err);
      alert("No se pudo eliminar la persona");
    }
  },
};
