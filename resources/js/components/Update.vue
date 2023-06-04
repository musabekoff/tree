<template>
    <div v-if="isAuth" style="display: inline-block">
        <div @click="isOpen = true" class="update_item">
            Изменить
        </div>
        <div v-if="isOpen" class="modal">
            <div class="modal__panel">
                <div class="modal__header">
                    Изменить
                    <span class="close" @click="isOpen = false">&times;</span>
                </div>
                <div class="modal__body">
                    <div class="error__text" v-if="error">{{ error }}</div>
                    <div class="input__group">
                        <label for="main">Main</label>
                        <input v-model="form.main" type="text" id="main" required>
                    </div>
                    <div class="input__group">
                        <label for="spouse">Spouse</label>
                        <input v-model="form.spouse" type="text" id="spouse" required>
                    </div>
                    <div class="input__group">
                        <label for="content">Content</label>
                        <vue-editor v-model="form.content" rows="3" type="text" id="content"></vue-editor>
                    </div>
                    <template v-if="form.image">
                        <div class="image__panel">
                            <span @click="deleteImage">&times;</span>
                            <img width="100%" :src="form.image" :alt="form.main">
                        </div>
                    </template>
                    <template v-else>
                        <div class="input__group">
                            <input type="file" class="form-control" v-on:change="onImageChange">
                        </div>
                    </template>
                </div>
                <div class="modal__footer">
                    <button class="add" @click="update">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import {VueEditor} from "vue2-editor";

export default {
    name: "Update",
    components: {
        VueEditor
    },
    props: {
        id:null,
        main:null,
        spouse:null,
        content:null,
        image:null,
        parentId:null,
    },
    data: function () {
        return {
            isAuth: false,
            isOpen: false,
            form: {
                main: '',
                spouse: '',
                content: '',
                image: '',
                parentId: '',
            },
            error: ''
        }
    },
    mounted() {
        this.isAuth = !!this.$cookies.get("isAuth");
        this.form.main = this.main
        this.form.spouse = this.spouse
        this.form.content = this.content
        this.form.image = this.image
        this.form.parentId = this.parentId
    },
    methods: {
        onImageChange(e){
            this.form.image = e.target.files[0];
            console.log(e.target.files[0]);
        },
        update: function () {
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }

            let formData = new FormData();
            formData.append('id', this.id);
            formData.append('image', this.form.image);
            formData.append('main', this.form.main);
            formData.append('spouse', this.form.spouse);
            formData.append('text', this.form.content);
            formData.append('parentId', this.form.parentId);
            axios.post('/api/update', formData, config)
                .then(res => {
                    this.$emit('imageUpdate', res.data)
                    this.isOpen = false
                })
                .catch(err => {
                    console.log(err)
                })
        },
        deleteImage() {
            axios.get('/api/delete-image/'+this.id)
                .then(res => {
                    this.$emit('imageUpdate', res.data)
                    this.form.image = ''
                })
                .catch(err => {
                    console.log(err)
                })
        }
    },
    watch: {
        'form.main': {
            immediate: true,
            handler(val) {
                if (val.length > 0) {
                    this.error = ''
                }
            }
        },
        'form.spouse': {
            immediate: true,
            handler(val) {
                if (val.length > 0) {
                    this.error = ''
                }
            }
        }
    }
}
</script>

<style scoped>

</style>
