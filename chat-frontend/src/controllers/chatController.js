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
  /** 🧾 Listar todos los chats */
  async listar(callback) {
    try {
      const data = await ChatModel.listar();
      callback(data);
    } catch (err) {
      console.error("Error al listar chats:", err);
      alert("No se pudieron cargar los chats");
    }
  },

  /** ➕ Crear un nuevo chat */
  async crear(chatData, reloadCallback) {
    try {
      await ChatModel.crear(chatData);
      if (reloadCallback) reloadCallback();
    } catch (err) {
      console.error("Error al crear chat:", err);
      alert("No se pudo crear el chat");
    }
  },

  /** ✏️ Actualizar un chat existente */
  async actualizar(id, chatData, reloadCallback) {
    try {
      await ChatModel.actualizar(id, chatData);
      if (reloadCallback) reloadCallback();
    } catch (err) {
      console.error("Error al actualizar chat:", err);
      alert("No se pudo actualizar el chat");
    }
  },

  /** 🗑️ Eliminar un chat */
  async eliminar(id, reloadCallback) {
    try {
      if (confirm("¿Eliminar este chat?")) {
        await ChatModel.eliminar(id);
        if (reloadCallback) reloadCallback();
      }
    } catch (err) {
      console.error("Error al eliminar chat:", err);
      alert("No se pudo eliminar el chat");
    }
  },
};