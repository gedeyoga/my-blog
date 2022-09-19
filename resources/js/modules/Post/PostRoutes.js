
import PostList from "./components/PostList";
import PostForm from "./components/PostForm";

export default [
    {
        path: "/admin/posts/",
        name: "posts.index",
        component: PostList,
    },
    {
        path: "/admin/posts/:post/draft",
        name: "posts.draft",
        component: PostForm,
    },
];