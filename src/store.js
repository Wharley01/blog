import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios';

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
      fb_profile_link: 'https://',
      remote_docs_path: '/docs/v0.0.1',
      route_is_loading: true,
      docs_files_tree:[],
      page_content:null,
      current_page: 0,
      doc_map_obj:[]
  },
    mutations: {
        UPDATE_LOAD_STATE(state,load_state){
            state.route_is_loading = load_state;
        },
        SET_DOCS_FILES_TREE(state,data){
            state.docs_files_tree = data;
        },
        SET_PAGE_CONTENT(state,content){
            state.page_content = content;
        },
        SET_CURRENT_PAGE(state,page_index){
            state.current_page = page_index;
        },
        SET_DOC_MAP(state,map){
            state.doc_map_obj = map;
        }
    },
})
