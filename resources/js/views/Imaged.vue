<template>
    <section class="main-page imaged">
        <add v-if="data" :parent-id="data.id" @update="updateData"></add>
        <div class="tree" v-if="data">
            <div v-if="data.items.length" class="tree__items"  style="background-image: url('images/bg.png')">
                <template v-for="item in data.items">
                    <div class="tree__item">
                        <router-link :to="{name: 'ImagedItem', params: { slug: item.slug}}" class="tree__items_image" :style="{'background-image':`url(${item.image.length ? item.image : 'images/user.png'})`}"></router-link>
                        <router-link :to="{name: 'ImagedItem', params: { slug: item.slug}}" class="tree__items_info">
                            <div class="tree__items_main" v-html="item.main"></div>
                            <div class="tree__items_spouse" v-html="item.spouse"></div>
                        </router-link>
                        <update :id="item.id" :main="item.main" :spouse="item.spouse" :content="item.content" :image="item.image" :parentId="item.parentId" @imageUpdate="updateData"></update>
                        <span v-if="isAuth" class="delete__item" @click="deleteItem(item.id)">Удалить</span>
                    </div>
                </template>
            </div>
            <div class="tree__main">
                <div class="tree__main_image" :style="{'background-image':`url(${data.image})`}"></div>
                <div class="tree__main_info" :class="data.content ? 'is-info' : ''">
                    <div class="tree__main_main" v-html="data.main"></div>
                    <div class="tree__main_spouse" v-html="data.spouse"></div>
                </div>
            </div>
            <div v-if="data.content" class="tree__main_content" v-html="data.content"></div>
        </div>
    </section>
</template>

<script>
import Add from "../components/Add";
import Update from "../components/Update";
import axios from "axios";
export default {
    name: "Imaged",
    components: {Update, Add},
    data: function () {
        return {
            data: null,
            isAuth: false
        }
    },
    mounted() {
        this.getMain()
        this.isAuth = !!this.$cookies.get("isAuth");
    },
    methods: {
        getMain() {
            axios.get('/api/main')
                .then(res => {
                    this.data = res.data[0]
                })
                .catch(err => {
                    console.log(err.message)
                })
        },
        updateData(data) {
            this.data = data[0]
        },
        deleteItem(id) {
            axios.get('/api/delete/'+id)
                .then(res => {
                    this.data = res.data[0]
                })
                .catch(err => {
                    console.log(err.message)
                })
        }
    }
}
</script>

<style scoped>
    body {
        background-color: red !important;
    }
</style>
