FROM node:20-alpine

WORKDIR /app
COPY chat-frontend/ /app/
RUN npm install

EXPOSE 5173
CMD ["npm", "run", "dev", "--", "--host"]


