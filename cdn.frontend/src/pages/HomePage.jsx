import { useEffect, useState } from "react";
import { getArticles, createArticle } from "../api/articleApi";
import ArticleTable from "../components/ArticleTable";

export default function HomePage({ user }) {
  const [articles, setArticles] = useState([]);
  const [title, setTitle] = useState("");
  const [body, setBody] = useState("");
  const [error, setError] = useState("");

  const fetchArticles = async () => {
    try {
      const data = await getArticles();
      setArticles(data);
    } catch (err) {
      setError(err.error || "Failed to load articles");
    }
  };

  useEffect(() => {
    fetchArticles();
  }, []);

const handleCreate = async () => {
  setError("");
  try {
    if (!title || !body) throw new Error("Title and body are required");
    const article = await createArticle(title, body);
    setArticles([article, ...articles]); // newest first
    setTitle("");
    setBody("");
  } catch (err) {
    setError(err.response?.data?.error || err.message || "Failed to create article");
  }
};

  return (
    <div style={{ padding: "2rem" }}>
      <h1>Hi {user.username}</h1>
      <div className = "container">
        <h2>Create Article</h2>
        {error && <p className = "error">{error}</p>}
        <input
          type="text"
          placeholder="Title"
          value={title}
          onChange={(e) => setTitle(e.target.value)}
        />
        <br />
        <textarea
          placeholder="Body"
          value={body}
          onChange={(e) => setBody(e.target.value)}
        />
        <br />
        <button onClick={handleCreate}>Create</button>
      </div>

      <ArticleTable
        articles={articles}
        setArticles={setArticles}
        user={user}
      />
    </div>
  );
}



