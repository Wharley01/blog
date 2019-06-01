<template>
    <div class="blog-wrap">
        <div class="grid grid-1x4">
            <div class="bg-color-white shadow-normal side-bar">
                <div class="logo column relative">
                    <router-link to="/" class="center margin-left-auto margin-right-auto"><img src="../assets/images/path-logo.png"/></router-link>
                    <p class="margin-auto">Documentation</p>
                    <button @click="show_menu = !show_menu" class="menu absolute show-on-mobile-only" style="z-index: 10">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
                <div class="nav-links" :class="{'show':show_menu}" v-html="doc_map_html()">
                </div>
            </div>
            <div class="doc-content-wrap flex column">
                <div class="doc-content padding-left-md padding-right-md">
                    <div v-if="page_content != null">
                       <vue-mark-down :toc="true">{{page_content}}</vue-mark-down>
                    </div>
                </div>
                <div class="flex row-responsive full-width space-between padding-md margin-top-auto">
                    <a v-if="prev_link()(doc_id)" class="margin-right-auto margin-top-xxxsm" :href="prev_link()(doc_id).link">
                        <button :class="{'clickable':prev_link()(doc_id).is_navigable}">
                            {{prev_link()(doc_id).text}}
                        </button>
                    </a>

                    <a v-if="" class="margin-left-auto margin-top-xxxsm" :href="next_link()(doc_id).link">
                    <button :class="{'clickable': !next_link()(doc_id).is_navigable}" v-if="next_link()(doc_id)">
                       {{next_link()(doc_id).text}}
                    </button>
                    </a>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    // @ is an alias to /src
    import axios from "axios";
    import {mapActions,mapState,mapMutations,mapGetters} from 'vuex';
    import VueMarkDown from 'vue-markdown';
    import Prism from 'prismjs';
    import 'prismjs/prism';
    import 'prismjs/components/prism-markup-templating';
    import 'prismjs/components/prism-php'
    import 'prismjs/components/prism-bash'
    import '../assets/css/prism-atom-dark.css';
//    import 'prism-theme-night-owl';

    export default {
        name: 'Blog',
        components:{
            VueMarkDown
        },
        data(){
            return{
                doc_content: null,
                doc_id: 0,
                show_menu: false
            }
        },
        computed: {
            ...mapState([
                'page_content',
                'docs_files_tree'
            ])
        },
        async created(){
//            fetch data
            let doc_id = this.$route.params.doc_id || 0;
            this.doc_id = doc_id;

            doc_id = parseInt(doc_id);
            this.UPDATE_LOAD_STATE(true);
            this.initiatePage(doc_id);
        },
        mounted(){
            Prism.highlightAll();
            let doc_id = this.$route.params.doc_id || 0;
            this.doc_id = doc_id;
        },
        updated(){
            Prism.highlightAll();
            let doc_id = this.$route.params.doc_id || 0;
            this.doc_id = doc_id;
        },
        methods:{
            attachClickToSections(){
                console.log();
                let total = this.docs_files_tree.length;
                for(let i = 0; i < total; i++){
                    let elem = document.getElementById('section_'+i);
                    let a_id = parseInt(this.$route.params.doc_id);
                    if(i === a_id){
                        elem.classList.toggle('show');
                    }
                    elem.addEventListener('click', function (e) {
                        if(i !== a_id || e.target.id === elem.id) {
                            elem.classList.toggle('show');
                        }
                    })
                }
            },
            async initiatePage(doc_id){
                await  this.fetchDocFiles();
                await  this.fetchDocMap();

                await this.fetchFileContentById(doc_id);
                this.UPDATE_LOAD_STATE(false);
                this.attachClickToSections();
            },
            ...mapActions([
                'fetchDocFiles',
                'fetchFileContentById',
                'fetchDocMap'
            ]),
            ...mapMutations([
                'UPDATE_LOAD_STATE'
            ]),
            ...mapGetters([
                'doc_map_html',
                'next_link',
                'prev_link'
            ])
        },
        watch:{
            '$route':function (to,from) {
                let doc_id = to.params.doc_id || 0;
                doc_id = parseInt(doc_id);
                this.UPDATE_LOAD_STATE(true);
                this.initiatePage(doc_id);
            },
            '$route.params.doc_id': function () {
                this.doc_id = this.$route.params.doc_id
            }
        }
    }
</script>
<style lang="scss" >
    @import "../assets/css/styles";
    .blog-wrap{

        .side-bar{
            max-height: 100vh;
            width: 100%;
            overflow: auto;
            .menu{
                right: 10px;
                top: 35px;
            }
            .logo{
                @extend .bg-color-grey-shade-3;
                @extend .padding-top-xxsm;
                @extend .padding-bottom-xxsm;

                @extend .flex;
                img{
                    max-width: 240px;
                    width: 100%;
                    height: auto;
                    margin: auto;
                    align-self: center;
                }
            }
            ul{
                @extend .padding-top-xxxsm;
                @extend .padding-bottom-xxxsm;
                @extend .padding-left-xxsm;
                @extend .padding-right-xxsm;

                @extend .margin-none;
                list-style-type: none;
                li{

                }
                li.root{
                    >a {
                        @extend .padding-left-xxsm;
                        @extend .padding-right-xxsm;
                        @extend .padding-top-xxxsm;
                        @extend .padding-bottom-xxxsm;
                        @extend .bg-color-grey-shade-3;
                        @extend .margin-top-xxsm;

                        display: block;
                    }
                    >ul{
                        display: none;
                        @extend .margin-left-xxsm;
                        li{
                            @extend .margin-top-xxxsm
                        }
                    }

                }

                li.show{
                    >ul{
                        display: block!important;
                    }

                }
            }
        }
        .doc-content-wrap{
            overflow: auto;
            min-height: 0;
            height: 100vh;
        }
        .doc-content{
            flex: auto;
            /*overflow: auto;*/
            /*min-height: 0;*/
            font-size: 19px;
            line-height: 170%;
        }

        button{
            @extend .bg-color-white;
            @extend .padding-left-xxsm;
            @extend .padding-right-xxsm;
            @extend .padding-top-xxxsm;
            @extend .padding-bottom-xxxsm;
            @extend .shadow-dark;
            @extend .border-color-none;
            @extend .border-round-xxxsm;
            @extend .txt-size-xxsm;
            @extend .txt-color-black;
            @extend .txt-center;
            font-weight: bold;
            font-family: inherit;
            cursor: pointer;
            letter-spacing: 3px;
        }
        button.clickable{
            @extend .bg-color-link-color;
            @extend .txt-color-white;
        }
        code:not([class]){
            /*color: #fff;*/
            /*font-size: 18px!important;*/
            background: #96CBFE;
        }
        pre:not([class]){
            overflow: auto;
            background: #96CBFE;
            @extend .padding-xxsm
        }
        table{
            border-collapse: collapse;
            thead{
                @extend .bg-color-grey-shade-3;
                th{
                    @extend .padding-xxxsm;
                }
            }
            tbody{
                td{
                    @extend .padding-xxxsm;
                    border-bottom: 1px solid #dcdcdc;
                }
            }
        }
    }
</style>
