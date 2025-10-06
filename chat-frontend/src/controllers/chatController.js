import { ChatModel } from "../models/chatModel";
import { user } from "../models/user.svelte";

export function connectChat(onMessage) {
  const ws = new WebSocket("ws://localhost:8080");
  ws.onopen = () => console.log("Conectado");
  ws.onmessage = (e) => onMessage(JSON.parse(e.data));
  return ws;
}

export function sendMessage(ws, contenido) {
  ws.send(JSON.stringify({
    chatId: 1,
    personaId: user.id,
    contenido,
    fecha: new Date().toISOString()
  }));
}

export const ChatController = {
  async listar(callback) {
    try {
      const data = await ChatModel.listar();
      callback(data);
    } catch (err) {
      console.error(err);
      alert("No se pudieron cargar los chats");
    }
  },

  async eliminar(id, reloadCallback) {
    try {
      if (confirm("¿Eliminar este chat?")) {
        await ChatModel.eliminar(id);
        reloadCallback();
      }
    } catch (err) {
      console.error(err);
      alert("No se pudo eliminar el chat");
    }
  },
};