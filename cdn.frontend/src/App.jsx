import { useState } from "react";
import LoginPage from "./pages/LoginPage";
import HomePage from "./pages/HomePage";

function App() {
  const [user, setUser] = useState(null);

  return (
    <div>
      {!user ? (
        <LoginPage onLogin={(u) => setUser(u)} />
      ) : (
        <HomePage user={user} />
      )}
    </div>
  );
}

export default App;
