<template>
    <section v-if="isAuth">
        <div @click="isOpen = true" class="add__tree">Добавить</div>
        <div v-if="isOpen" class="modal">
            <div class="modal__panel">
                <div class="modal__header">
                    Добавить
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
                        <vue-editor  v-model="form.content" rows="3" type="text" id="content"></vue-editor>
                    </div>
                    <div class="input__group">
                        <input type="file" class="form-control" v-on:change="onImageChange">
                    </div>
                </div>
                <div class="modal__footer">
                    <button class="add" @click="created">Добавить</button>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import axios from "axios";
import { VueEditor } from "vue2-editor";

export default {
    name: "Add",
    components: {
        VueEditor
    },
    props: {
        parentId: {
            type: Number,
            default: null
        }
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
        this.form.parentId = this.parentId
    },
    methods: {
        onImageChange(e){
            console.log(e.target.files[0]);
            this.form.image = e.target.files[0];
        },
        created: function () {
            if (this.form.main && this.form.spouse) {
                this.error = ''
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }
                let formData = new FormData();
                formData.append('image', this.form.image);
                formData.append('main', this.form.main);
                formData.append('spouse', this.form.spouse);
                formData.append('text', this.form.content);
                formData.append('parent_id', this.form.parentId);
                axios.post('/api/set', formData, config)
                    .then(res => {
                        this.$emit('update', res.data)
                        this.isOpen = false
                    })
                    .catch(err => {
                        console.log(err)
                    })
            } else {
                this.error = 'Заполните все поля'
            }
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
