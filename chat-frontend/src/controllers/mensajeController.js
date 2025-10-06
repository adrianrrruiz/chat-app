import { MensajeModel } from "../models/mensajeModel";


export const MensajeController = {
  async listar(callback) {
    try {
      const data = await MensajeModel.listar();
      callback(data);
    } catch (err) {
      console.error(err);
      alert("No se pudieron cargar las mensajes");
    }
  },

  async eliminar(id, reloadCallback) {
    try {
      if (confirm("¿Eliminar este mensaje?")) {
        await MensajeModel.eliminar(id);
        reloadCallback();
      }
    } catch (err) {
      console.error(err);
      alert("No se pudo eliminar la persona");
    }
  },
};
