<template>
    <section class="main-page main">
        <add v-if="data" :parent-id="data.id" @update="updateData"></add>
        <div class="tree" v-if="data">
            <div class="tree__items" v-if="data.items.length">
                <div v-for="item in data.items" class="tree__item">
                    <div class="tree__items_image" :style="{'background-image':`url(${item.image.length ? item.image : 'images/user.png'})`}"></div>
                    <div class="tree__items_info">
                        <div class="tree__items_main" v-html="item.main"></div>
                        <div class="tree__items_spouse" v-html="item.spouse"></div>
                    </div>
                    <router-link class="route__link" :to="{name: 'Item', params: { slug: item.slug}}">Подробнее</router-link>
                    <update :id="item.id" :main="item.main" :spouse="item.spouse" :content="item.content" :image="item.image" :parentId="item.parentId" @imageUpdate="updateData"></update>
                    <span v-if="isAuth" class="delete__item" @click="deleteItem(item.id)">Удалить</span>
                </div>
            </div>
            <hr class="hr__line">
            <div class="tree__main">
                <div class="tree__main_image" :style="{'background-image':`url(${data.image})`}"></div>
                <div class="tree__main_info" :class="data.content ? 'is-info' : ''">
                    <div class="tree__main_main" v-html="data.main"></div>
                    <div class="tree__main_spouse" v-html="data.spouse"></div>
                </div>
                <update :id="data.id" :main="data.main" :spouse="data.spouse" :content="data.content" :image="data.image" :parentId="data.parentId" :is-main="true" @imageUpdate="updateData"></update>
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
    name: "Index",
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

</style>
