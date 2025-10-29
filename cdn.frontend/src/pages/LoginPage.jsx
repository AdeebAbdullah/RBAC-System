import { useState } from "react";
import { loginUser } from "../api/articleApi";

export default function LoginPage({ onLogin }) {
  const [username, setUsername] = useState("");
  const [error, setError] = useState("");

  const handleLogin = async () => {
    try {
      const headerValue = `User ${username}`;
      localStorage.setItem("usernameHeader", headerValue);
      const user = await loginUser(username); // /me endpoint
      onLogin(user); // pass user info to parent
    } catch (err) {
      setError(err.error || "Unknown error");
    }
  };

  return (
    <div style={{ padding: "2rem" }}>
    <h1 style={{ color: "#4a90e2", fontSize: "2.5rem", marginBottom: "1rem" }}>
        Role Based Access Control System
    </h1>
      <h1>Login</h1>
      <input
        type="text"
        placeholder="Username (admin, ed, vi)"
        value={username}
        onChange={(e) => setUsername(e.target.value)}
      />
      <button onClick={handleLogin}>Login</button>
      {error && <p style={{ color: "red" }}>{error}</p>}
    </div>
  );
}
