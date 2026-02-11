import express from "express";
import http from "http";
import { Server } from "socket.io";

const app = express();
const server = http.createServer(app);
const io = new Server(server);

const rooms = {};
const wins = [
    [0, 1, 2],
    [3, 4, 5],
    [6, 7, 8],
    [0, 3, 6],
    [1, 4, 7],
    [2, 5, 8],
    [0, 4, 8],
    [2, 4, 6],
];

app.get("/", (req, res) => {
    res.send(`
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>XO Room Game</title>
<script src="/socket.io/socket.io.js"></script>
<style>
body{background:linear-gradient(135deg,#1d2671,#c33764);color:#fff;font-family:sans-serif;text-align:center}
.board{display:grid;grid-template-columns:repeat(3,110px);gap:10px;justify-content:center;margin:20px}
.cell{width:110px;height:110px;background:#ffffff22;font-size:3rem;border-radius:15px;display:flex;align-items:center;justify-content:center;cursor:pointer}
.o{color:#2ecc71}.x{color:#e74c3c}
.win{animation:glow .6s infinite alternate}
@keyframes glow{from{box-shadow:0 0 10px}to{box-shadow:0 0 25px}}
button,input{padding:10px;border-radius:8px;border:none;margin:5px}
button{background:#27ae60;color:#fff}
</style>
</head>
<body>
 
<h1>XO Multiplayer</h1>
<input id="room" placeholder="Room ID">
<button onclick="join()">Join</button>
 
<h2 id="role"></h2>
<h3 id="turn"></h3>
 
<div class="board" id="board"></div>
<div id="msg"></div>
<button onclick="resetGame()">Reset</button>
 
<script>
const socket=io();
let roomId="",mySymbol="",myTurn=false;
 
function join(){
  roomId=document.getElementById("room").value;
  socket.emit("join",roomId);
}
 
socket.on("assign",sym=>{
  mySymbol=sym;
  document.getElementById("role").innerText="You are: "+sym;
});
 
socket.on("state",data=>{
  myTurn = data.turn===mySymbol;
  document.getElementById("turn").innerText = myTurn ? "✅ Your Turn" : "⏳ Opponent Turn";
  render(data.board,data.winLine);
  if(data.winner){
    document.getElementById("msg").innerText =
      data.winner===mySymbol ? "🎉 Congratulations!" : "😢 You Lost";
  }
});
 
function render(board,win){
  const el=document.getElementById("board"); el.innerHTML="";
  board.forEach((v,i)=>{
    const d=document.createElement("div");
    d.className="cell "+(v==="O"?"o":"x");
    if(win && win.includes(i)) d.classList.add("win");
    d.innerText=v;
    d.onclick = () => {
  if (myTurn && !v) {
    socket.emit("move", { roomId, index: i });
  }
};
    el.appendChild(d);
  });
}
 
function resetGame(){
  socket.emit("reset",roomId);
  document.getElementById("msg").innerText="";
}
</script>
 
</body>
</html>
`);
});

/* ✅ SOCKET LOGIC */
io.on("connection", (socket) => {
    socket.on("join", (roomId) => {
        socket.join(roomId);

        if (!rooms[roomId]) {
            rooms[roomId] = {
                players: [],
                board: Array(9).fill(""),
                turn: "O",
                started: false,
            };
        }

        const room = rooms[roomId];

        // Only 2 players allowed
        if (room.players.length >= 2) return;

        const symbol = room.players.length === 0 ? "O" : "X";
        room.players.push({ id: socket.id, symbol });

        socket.emit("assign", symbol);

        // ✅ Start game ONLY when 2 players joined
        if (room.players.length === 2) {
            room.started = true;
        }

        io.to(roomId).emit("state", room);
    });
    socket.on("move", ({ roomId, index }) => {
        const r = rooms[roomId];
        if (!r || !r.started) return; // ❌ game not started

        const player = r.players.find((p) => p.id === socket.id);
        if (!player) return;

        // ❌ Wrong turn OR cell already filled
        if (player.symbol !== r.turn || r.board[index]) return;

        r.board[index] = player.symbol;
        r.turn = r.turn === "O" ? "X" : "O";

        // Winner check
        for (let w of wins) {
            if (w.every((i) => r.board[i] === player.symbol)) {
                r.winner = player.symbol;
                r.winLine = w;
            }
        }

        io.to(roomId).emit("state", r);
    });

    socket.on("reset", (roomId) => {
        const r = rooms[roomId];
        r.board = Array(9).fill("");
        r.turn = "O";
        r.winner = null;
        r.winLine = null;
        io.to(roomId).emit("state", r);
    });
});
server.listen(3001, "0.0.0.0", () => {
    console.log("Server running on all network interfaces");
});
