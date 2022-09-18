
import PostList from "./components/PostList";
import PostForm from "./components/PostForm";

export default [
    {
        path: "/admin/posts/",
        name: "posts.index",
        component: PostList,
    },
    {
        path: "/admin/posts/create",
        name: "posts.create",
        component: PostForm,
    },
    {
        path: "/admin/posts/:category/edit",
        name: "posts.edit",
        component: PostForm,
    },
];