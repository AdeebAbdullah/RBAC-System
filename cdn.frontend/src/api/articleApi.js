import axios from "axios";

const API_URL = "http://localhost:8000/api"; // Laravel API URL

const axiosClient = axios.create({
  baseURL: API_URL,
});

// Interceptor to attach header
axiosClient.interceptors.request.use((config) => {
  const token = localStorage.getItem("usernameHeader");
  if (token) {
    config.headers["Authorization"] = token; // "User admin" etc.
  }
  return config;
});

export const loginUser = async (username) => {
  try {
    // test login via /me endpoint
    const res = await axiosClient.get("/me");
    return res.data;
  } catch (error) {
    throw error.response.data; // same as middleware error messages
  }
};

export const getArticles = async () => {
  const res = await axiosClient.get("/articles");
  return res.data.articles;
};

export const createArticle = async (title, body) => {
  const res = await axiosClient.post("/articles", { title, body });
  return res.data.article;
};

export const deleteArticle = async (id) => {
  await axiosClient.delete(`/articles/${id}`);
};
