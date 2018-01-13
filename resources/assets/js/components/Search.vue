<template>
    <div>
        <div>
            <div>
                <input type="search" id="aa-search-input" class="aa-input-search" placeholder="Find clouts" name="search" autocomplete="off" v-model="query" @keyup.enter="search()">
                <svg class="aa-input-icon" viewBox="654 -372 1664 1664">
                    <path d="M1806,332c0-123.3-43.8-228.8-131.5-316.5C1586.8-72.2,1481.3-116,1358-116s-228.8,43.8-316.5,131.5  C953.8,103.2,910,208.7,910,332s43.8,228.8,131.5,316.5C1129.2,736.2,1234.7,780,1358,780s228.8-43.8,316.5-131.5  C1762.2,560.8,1806,455.3,1806,332z M2318,1164c0,34.7-12.7,64.7-38,90s-55.3,38-90,38c-36,0-66-12.7-90-38l-343-342  c-119.3,82.7-252.3,124-399,124c-95.3,0-186.5-18.5-273.5-55.5s-162-87-225-150s-113-138-150-225S654,427.3,654,332  s18.5-186.5,55.5-273.5s87-162,150-225s138-113,225-150S1262.7-372,1358-372s186.5,18.5,273.5,55.5s162,87,225,150s113,138,150,225  S2062,236.7,2062,332c0,146.7-41.3,279.7-124,399l343,343C2305.7,1098.7,2318,1128.7,2318,1164z" />
                </svg>
                <br>
                <br>
                <div class="row" v-if="results.length">
                    <div  v-for="user in results">
                        <img :src="user.avatar" alt="" width="70px" height="70px" class="avatar-feed">
                        <h4 class="text-center">{{ user.name }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    var algoliasearch = require('algoliasearch');

    var client = algoliasearch("P52XNZR6SP", "cac9898766011d69ddf52e0c68797cdd");

    var index = client.initIndex('users');

    /*
    index.setSettings({
        "searchableAttributes": [
            "name",
            "username",
            "email",
        ],
    });
    */
    export default {
        mounted() {
            autocomplete('#aa-search-input', { 
                hint: false, 
            }, 
            {
                source: autocomplete.sources.hits(index, {hitsPerPage: 5}),
                    //value to be displayed in input control after user's suggestion selection
                    displayKey: 'name',
                    //hash of templates used when rendering dataset
                    templates: {
                        //'suggestion' templating function used to render a single suggestion
                        suggestion: function(suggestion) {
                            console.log(suggestion)
                        return '<span><a href="http://social/profile/' + suggestion.username +'">' +suggestion._highlightResult.name.value + '</a></span>';
                        }
                    }
            });
        }, 
        data() {
            return {
                query: '',
                results: [],
            }
        },
        methods: {
            search() {
                index.search(this.query, (err, content) => {
                    this.results = content.hits
                    console.log(err, content)
                })
            }
        }
    }
</script>

<style>
    .aa-input-search {
        width: 300px;
        border: 1px solid rgba(228, 228, 228, 0.6);
        padding: 12px 28px 12px 12px;
        box-sizing: border-box;
        appearance: none; 
        -webkit-appearance: none;
        -moz-appearance: none;
        position: relative;
        margin-top: 4%;
    }
    .aa-input-search::-webkit-search-decoration, .aa-input-search::-webkit-search-cancel-button, .aa-input-search::-webkit-search-results-button, .aa-input-search::-webkit-search-results-decoration {
        display: none; 
    }
    .aa-input-icon {
        height: 16px;
        width: 16px;
        position: absolute;
        top: 50%;
        right: 16px;
        transform: translateY(-50%);
        -webkit-transform: translateY(-50%);
        fill: #e4e4e4; 
    }
    .aa-dropdown-menu {
        background-color: #fff;
        border: 1px solid rgba(228, 228, 228, 0.6);
        min-width: 300px;
        margin-top: 10px;
        box-sizing: border-box; 
    }
    .aa-suggestion {
        padding: 12px;
        cursor: pointer;
    }
    .aa-suggestion + .aa-suggestion {
        border-top: 1px solid rgba(228, 228, 228, 0.6);
    }
    .aa-suggestion:hover, .aa-suggestion.aa-cursor {
        background-color: rgba(241, 241, 241, 0.35); 
    }
    .avatar-feed {
        border-radius: 50%;
    }
</style>