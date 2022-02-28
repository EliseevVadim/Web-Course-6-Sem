<template>
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="false" style="display: block; opacity: 1" v-if = visible>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{ title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click.prevent="closeWindow()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ message }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click.prevent="closeWindow()">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "RequestResultWindow",
    data() {
        return {
            visible: false,
            title: "",
            message: ""
        }
    },
    methods: {
        showWindow () {
            this.visible = true;
        },
        closeWindow () {
            this.visible = false;
        },
        setTitle (title) {
            this.title = title;
        },
        setMessage (content) {
            this.message = content;
        }
    }
}
</script>
