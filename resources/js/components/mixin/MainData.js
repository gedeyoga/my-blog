export default {
    data() {
        return  {
            user: window.admin_panel.user
        }
    },

    methods : {
        previewImage(url_image){
            this.$imagePreview({
                initIndex: 0,
                images: url_image,
                zIndex: 999999999999999
            });
        }
    }
}