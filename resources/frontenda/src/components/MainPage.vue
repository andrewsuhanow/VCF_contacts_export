<template>

    <v-app id="inspire">
        <v-navigation-drawer
            v-model="drawer"
            app
            clipped
        >
            <v-list dense>
                <v-list-item link href="/api/FirstPage">
                    <v-list-item-action>
                        <v-icon>mdi-view-dashboard</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
<!--                        <v-list-item-title>First page</v-list-item-title>-->
                        <v-list-item-title>Main page</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
<!--                <v-list-item link href="/api/LoadFilePage">-->
<!--                --/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--   -->
                <v-list-item link>
                    <v-list-item-action>
                        <v-icon>mdi-settings</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
<!--                        <v-list-item-title>Load Data from file</v-list-item-title>-->
                        <v-list-item-title @click="LoadDataFromFile">Load Data from file</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <!--                --/--/--/--/--/--/--/--/--/--/--/--/--/--/--/--   -->
                <v-list-item link href="/api/StoredPage">
                    <v-list-item-action>
                        <v-icon>mdi-view-dashboard</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <!--                        <v-list-item-title>First page</v-list-item-title>-->
                        <v-list-item-title>Deleted contacts</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar
            app
            clipped-left
        >
            <v-app-bar-nav-icon @click.stop="drawer = !drawer"/>
<!--            <v-toolbar-title>Application111111</v-toolbar-title>-->
            <span class="title ml-3 mr-5">Application111111</span>


            <!--             FIND FIELD          -->
            <v-text-field
                v-model="findingText"
                solo-inverted
                flat
                hide-details
                label="Search"
                prepend-inner-icon="search"
            />

            <v-spacer></v-spacer>



            <v-btn @click="btnAddCard" class="btn_add_class" icon>
<!--                <v-icon>mdi-magnify</v-icon>-->
                <v-icon>{{ icons.mdiPencil }}</v-icon>
            </v-btn>



        </v-app-bar>


        <!--    -----.-------.-------------.----------------.-----------------.--------------------uh    -->

<!--        style="padding: 0px 0px 36px;"-->
        <v-content class="inspireBody" >
            <v-container
                class=""
                fluid
            >



                <v-row>
                    <v-col class="">
                        <router-view :findingText="findingText"
                                     ref="childComponent"
                                     @fButtonAddCardIsVisible="fButtonAddCardIsVisible"></router-view>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>

        <v-footer app>
            <span>&copy; 2019</span>
        </v-footer>
    </v-app>

</template>






<script>
    //import axios from "axios";


    import {
        mdiPencil,
        //mdiDelete,
    } from '@mdi/js'

    export default {
        name: "main-container",


        props: {
            source: String,
        },
        data: () => ({
            drawer: null,

            findingText: ' ',

            icons: {
                mdiPencil,
                //mdiDelete,
            },


        }),
        created () {
            this.$vuetify.theme.dark = true
        },
        methods:{
            LoadDataFromFile(){
                //console.log('hhhhhhh11111')
                this.$router.push({name: 'LoadFilePage' })
            },

            btnAddCard(){
                this.$refs.childComponent.btnAddCard();
            },

            // делаем кнопку добавления карт видимой или невидимой
            fButtonAddCardIsVisible(is){
                console.log("--------2222222222222222222-------- "+is);
                if(is == 1){
                    document.querySelector(".btn_add_class").classList.remove('hiddenCls');
                }
                else if(is == 0){
                    document.querySelector(".btn_add_class").classList.add('hiddenCls');
                }
            }
        },
        mounted() {
            console.log("--------mounted000000--------");

            // console.log(this.$route.path);
            // if(this.$route.params.id != undefined &&
            //     this.$route.name == '/api/FirstPage/'+this.$route.params.id)
            // {
            //     console.log('1111111111111');
            // }
            // if(this.$route.params.id != undefined &&
            //     this.$route.name == '/api/LoadFilePage/'+this.$route.params.id)
            // {
            //     console.log('222222222222222');
            // }
        },

        updated() {
            console.log("--------updated000000--------");
            // console.log(this.$route.path);
            //
            // if(this.$route.params.id != undefined &&
            //     this.$route.name == '/api/FirstPage/'+this.$route.params.id)
            // {
            //     console.log('1111111111111');
            // }
            // if(this.$route.params.id != undefined &&
            //     this.$route.name == '/api/LoadFilePage/'+this.$route.params.id)
            // {
            //     console.log('222222222222222-----');
            // }
        }
    }
</script>

<style scoped lang="scss">

    .hiddenCls {
        /*visibility: hidden;*/
        display: none;
    }

</style>


