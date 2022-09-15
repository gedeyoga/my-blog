
import CategoryList from "./components/CategoryList";
import CategoryForm from "./components/CategoryForm";

export default [
    {
        path: "/admin/categories/",
        name: "categories.index",
        component: CategoryList,
    },
    {
        path: "/admin/categories/create",
        name: "categories.create",
        component: CategoryForm,
    },
    {
        path: "/admin/categories/:category/edit",
        name: "categories.edit",
        component: CategoryForm,
    },
];