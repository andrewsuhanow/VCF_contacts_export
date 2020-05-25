<template >
<!--    <v-app >-->

         <div class="LoadFilePageCardEdit">

                  <v-card
                      color="#333333"
                      dark
                  >
                      <v-row dense>
                          <v-col cols="11">
                              <v-col cols="12" sm="6">
                                  <v-label></v-label>
                                      <v-text-field
                                          label="Name"
                                          v-model="fileData.FN"
                                          outlined
                                          dense
                                      ></v-text-field>
                              </v-col>
                              <v-col cols="12" sm="6">
                                  <v-text-field
                                      label="Telephone"
                                      v-model="fileData.TEL"
                                      outlined
                                      dense
                                  ></v-text-field>
                              </v-col>
                              <v-col cols="12" sm="6">
                                  <v-text-field
                                      label="Email"
                                      v-model="fileData.EMAIL"
                                      outlined
                                      dense
                                  ></v-text-field>
                              </v-col>
<!--                              <v-card-title class="headline">name: {{fileData.FN}}</v-card-title>-->
<!--                              <v-card-subtitle> TLF: {{fileData.TEL}}</v-card-subtitle>-->
<!--                              <v-card-subtitle>EMAIL: {{fileData.EMAIL}}</v-card-subtitle>-->


                              <v-card-actions>
                                  <v-btn @click="btnOk" text>Ok</v-btn>
                              </v-card-actions>

                          </v-col>


                      </v-row>
                  </v-card>


      </div>
<!--    </v-app>-->
</template>

<script>


    // import {
    //     mdiPencil,
    //     mdiDelete,
    // } from '@mdi/js'


export default {
  name: 'LoadFilePageCardEdit',

    props: ['fileData', 'index', 'updateData'],

    data() {
        return {

            // icons: {
            //     mdiPencil,
            //     mdiDelete,
            // },
        }
    },

    methods: {

      // пердача индекса, который нужно удалить
        // btnDel(index){
        //     //console.log(index)
        //     this.$emit('btnDel', index);
        // },

        btnOk(){

            this.$emit('saveEditData', this.index, this.fileData.FN, this.fileData.TEL, this.fileData.EMAIL);
            this.$emit('updateData');
            this.$router.push({name: 'LoadFilePage' })
        },
    }, // methods:


    mounted: function() {
        console.log("--------mounted3333--------");

        // скролинг к месту открытой карточки
        let x = document.querySelector(".cardNumClass"+this.$route.params.id).offsetLeft;
        let y = document.querySelector(".cardNumClass"+this.$route.params.id).offsetTop;
        window.scrollTo(x,y)

    },

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>


    /*.v-application--wrap, .override{*/
    /*    min-height: 1vh !important;*/
    /*}*/


</style>
