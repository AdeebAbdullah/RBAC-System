import { deleteArticle } from "../api/articleApi";

export default function ArticleTable({ articles, setArticles, user }) {
  const handleDelete = async (id) => {
    try {
      await deleteArticle(id);
      setArticles(articles.filter((a) => a.id !== id));
    } catch (err) {
      alert(err.error || "Failed to delete article");
    }
  };

  return (
    <div>
      <h2>Articles</h2>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Body</th>
            <th>Author ID</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          {articles.map((a) => (
            <tr key={a.id}>
              <td>{a.id}</td>
              <td>{a.title}</td>
              <td>{a.body}</td>
              <td>{a.author_id}</td>
              <td>
                {(user.role === "ADMIN" ||
                  (user.role === "EDITOR" && a.author_id === user.id)) && (
                  <button onClick={() => handleDelete(a.id)}>Delete</button>
                )}
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
