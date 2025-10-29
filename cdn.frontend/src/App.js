// src/App.js
import { useState } from "react";
import LoginPage from "./pages/LoginPage";
import HomePage from "./pages/HomePage";
import './App.css';


function App() {
  // user object after successful login: { username, role, permission }
  const [user, setUser] = useState(null);

  // logout function to reset app state
  const handleLogout = () => {
    localStorage.removeItem("usernameHeader");
    setUser(null);
  };

  return (
    <div className = "container">
      {!user ? (
        // if no user logged in, show login page
        <LoginPage onLogin={(userData) => setUser(userData)} />
      ) : (
        // if logged in, show homepage
        <div>
          <div className ="header">
            <div style={{ display: "flex", flexDirection: "column" }}>
              <h1>Welcome to RBAC-System</h1>
              <span style={{ fontSize: "0.8rem", color: "#e0e0e0" }}>By Adeeb</span>
            </div>
            <button onClick={handleLogout}>Logout</button>
          </div>
          <HomePage user={user} />
        </div>
      )}
    </div>
  );
}

export default App;
