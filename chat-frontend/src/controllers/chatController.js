import { user } from "../models/user";

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
