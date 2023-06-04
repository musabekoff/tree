<template>
    <section class="main-page main">
        <add v-if="data" :parent-id="data.id" @update="updateData"></add>
        <div class="tree" v-if="data">
            <div class="tree__items" v-if="data.items.length">
                <div v-for="item in data.items" class="tree__item">
                    <div class="tree__items_image" :style="{'background-image':`url(${item.image.length ? item.image : '../../images/user.png'})`}"></div>
                    <div class="tree__items_info">
                        <div class="tree__items_main" v-html="item.main"></div>
                        <div class="tree__items_spouse" v-html="item.spouse"></div>
                    </div>
                    <router-link class="route__link" :to="{name: 'Item', params: { slug: item.slug}}">Подробнее</router-link>
                    <update :id="item.id" :main="item.main" :spouse="item.spouse" :content="item.content" :image="item.image" :parentId="item.parentId" @imageUpdate="updateData"></update>
                    <span class="delete__item" @click="deleteItem(item.id)">Удалить</span>
                </div>
            </div>
            <hr v-if="data.items.length" class="hr__line">
            <div class="tree__main">
                <div class="tree__main_image" :style="{'background-image':`url(${data.image})`}"></div>
                <div class="tree__main_info" :class="data.content ? 'is-info' : ''">
                    <div class="tree__main_main" v-html="data.main"></div>
                    <div class="tree__main_spouse" v-html="data.spouse"></div>
                </div>
            </div>
            <div v-if="data.content" class="tree__main_content" v-html="data.content"></div>
            <template v-if="data.back.slug === false">
                <router-link :to="{name: 'Index'}" class="back_link">
                    <svg xmlns="http://www.w3.org/2000/svg" height="10" viewBox="0 -960 960 960" width="10"><path d="M400-80 0-480l400-400 56 57-343 343 343 343-56 57Z"/></svg>
                    {{ data.back.main }}
                </router-link>
            </template>
            <template v-else>
                <router-link :to="{name: 'Item', params: { slug: data.back.slug}}" class="back_link">
                    <svg xmlns="http://www.w3.org/2000/svg" height="10" viewBox="0 -960 960 960" width="10"><path d="M400-80 0-480l400-400 56 57-343 343 343 343-56 57Z"/></svg>
                    {{ data.back.main }}
                </router-link>
            </template>
        </div>
    </section>
</template>

<script>
import Add from "../components/Add";
import axios from "axios";
import Update from "../components/Update";
export default {
    name: "Item",
    components: {Update, Add},
    data: function () {
        return {
            data: null
        }
    },
    mounted() {
        this.getItem()
    },
    methods: {
        getItem() {
            axios.get('/api/item/'+this.$route.params.slug)
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
