<template >
<!--    <v-app >-->

         <div class="LoadFilePageCard" >

<!--             :class="{ hiddenCls: isFinded }"-->


                  <v-card
                      :disabled="isEditableNowHere"
                      v-if="isDisabledCardIndex!=index "
                      color="#333333"
                      dark
                  >
                      <v-row dense>
                          <v-col cols="11">
                              {{index}}
<!--                              {{isFinded}}-->
                              <v-card-title v-html="`name: ` + currFN" class="headline"> </v-card-title>
                              <v-card-subtitle> TLF: {{currTEL}}</v-card-subtitle>
                              <v-card-subtitle>EMAIL: {{currEMAIL}}</v-card-subtitle>

                          </v-col>
                          <v-col cols="1">

                                  <v-btn :id='"btnEdit"+index' @click="btnDel(index)">
                                      <v-icon>{{ icons.mdiDelete }}</v-icon>
                                  </v-btn>


                                  <v-btn id="btnDel" @click="edit(index)">
                                      <v-icon>{{ icons.mdiPencil }}</v-icon>
                                  </v-btn>
                          </v-col>

                      </v-row>
                  </v-card>
<!--                 <div v-if="isEditCard==true">-->
                 <div v-if="isDisabledCardIndex==index">
                     <router-view @saveEditData="saveEditData"
                                  :fileData="fileData"
                                  :index="index"
                                  @updateData="updateData"></router-view>

                 </div>

<!--             <div id="temp1"></div>-->
<!--             {{findingTextHere}}-->
      </div>


<!--    </v-app>-->
</template>

<script>


    import {
        mdiPencil,
        mdiDelete,
    } from '@mdi/js'


export default {
  name: 'LoadFilePageCard',

    props: ['fileData', 'index', 'isDisabledCardIndex', 'isEditableNow', 'findingText', 'setHideCardIndex'],

    data() {
        return {

            // currFN:  null,//this.fileData.FN,
            // currTEL: null,//this.fileData.TEL,
            // currEMAIL: null,//this.fileData.EMAIL,

            // currFN:  this.fileData.FN,
            // currTEL: this.fileData.TEL,
            // currEMAIL: this.fileData.EMAIL,

            isFinded: false,

            icons: {
                mdiPencil,
                mdiDelete,
            },
        }
    },

    methods: {


      // пердача индекса, который нужно удалить
        btnDel(index){
            console.log('btnDel')

            this.$emit('btnDel', index);
            //console.clear()

//--------------------------
            //this.$emit('setHideCardIndex', this.index, 'showAll')

        },

      // переход на страницу редактирование данных
        edit(i){
            //console.log(i);
            this.$emit('isEdit', i)

            //if(this.$route.params.id == undefined){
                this.$router.push({name: 'LoadFilePageCardEdit' , params: {id: i}})
            //}

        },

      // возврат со страницы редактирование данных
        saveEditData(i,FN,TEL,EMAIL){
            this.$emit('EditData', i, FN, TEL, EMAIL);
        },

        // возврат со страницы редактирование данных
        updateData(){
            this.currFN = this.fileData.FN;
            this.currTEL = this.fileData.TEL;
            this.currEMAIL = this.fileData.EMAIL;

            let str = this.fileData.FN.toLowerCase();
            let myFind = this.findingText.toLowerCase().trim();
            let findedIndex = str.search(myFind)

            if(myFind && myFind.length > 0) {
                if (findedIndex != -1) {
                    let resultStr = this.fileData.FN.slice(0, findedIndex)
                        + "<mark>" +
                        this.fileData.FN.slice(findedIndex, findedIndex + myFind.length)
                        + "</mark>" +
                        this.fileData.FN.slice(findedIndex + myFind.length);
                    this.currFN = resultStr;

                    return;
                }
            }
        },

    }, // methods:

    computed:{
        // если кликнули не по этому компоненту он disabled, вначале enabled все
        isEditableNowHere: function () {
            if(this.isDisabledCardIndex == null){
                    //this.isEditableNow = false;
                return false;
            }
            else if(this.isDisabledCardIndex == this.index){
                //this.isEditableNow = false;
                return false;
            }
            return true;
        },

        currFN: function() {


            let str = this.fileData.FN.toLowerCase();
            let myFind = this.findingText.toLowerCase().trim();
            let findedIndex = str.search(myFind)

            if(myFind && myFind.length > 0) {
                if (findedIndex != -1) {
                    this.$emit('setHideCardIndex', this.index, 'show')
                    let resultStr = this.fileData.FN.slice(0, findedIndex)
                        + "<mark>" +
                        this.fileData.FN.slice(findedIndex, findedIndex + myFind.length)
                        + "</mark>" +
                        this.fileData.FN.slice(findedIndex + myFind.length);

                    return resultStr;
                }
            }
            else if(myFind.length == 0){
                return this.fileData.FN;
            }
            //console.log('wwwwww;  '+myFind.length)
            this.$emit('setHideCardIndex', this.index, 'hide')
            return this.fileData.FN;

        },
        currTEL: function(){
            return this.fileData.TEL;
        },
        currEMAIL: function(){
            return this.fileData.EMAIL;
        },

        findingTextHere:  function(){
            //console.log(this.findingTextHere)
            return this.findingText;
        },


    }, // compute:


     watch: {
         findingTextHere: function(){

              let str = this.fileData.FN.toLowerCase();
              let myFind = this.findingText.toLowerCase().trim();
              let findedIndex = str.search(myFind)

              if(myFind && myFind.length > 0) {
                  if (findedIndex != -1) {
                      this.$emit('setHideCardIndex', this.index, 'show')

                          let resultStr = this.fileData.FN.slice(0, findedIndex)
                              + "<mark>" +
                              this.fileData.FN.slice(findedIndex, findedIndex + myFind.length)
                              + "</mark>" +
                              this.fileData.FN.slice(findedIndex + myFind.length);
                           this.currFN = resultStr;

                          return ;
                      }

                     this.$emit('setHideCardIndex', this.index, 'hide')
                     this.currFN = this.fileData.FN;
                     return ;
              }

             this.$emit('setHideCardIndex', this.index, 'showAll')

             return ;
         },

         // currFN: function(){
         //     //saveEditData(i,FN,TEL,EMAIL)
         //     console.log('hhhhh: '+ this.currFN)
         //     this.currFN = this.fileData.FN;
         // },
     },

    mounted: function() {
        console.log("--------Mount222--------");
        //console.log("-kkkkk" + this.$route.params.id);


        // // испльзуется если ввесть 'path/:id' ищет в базе данные с индексом -1 и если они есть
        // // открывает окно редактирования
        // if(this.$route.params.id != undefined  ){
        //     this.$emit('isEdit', this.$route.params.id)
        //     this.$router.push({name: 'Edit' , params: {id: this.$route.params.id}})
        //     //this.$router.push({name: 'LoadFilePage' })
        // }
    },

    updated: function() {
            console.log("---------updated222----------");

    },
    destroyed: function() {
        console.log("---------destroyed222----------");
    }

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>


</style>
