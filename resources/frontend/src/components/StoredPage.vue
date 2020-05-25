<template>
    <v-app>
  <div class="StoredPage">
    <h1>------Страница удаленных контактов--------</h1>
  </div>

        <v-container  v-for="(item, index) in mString" :key="index" :class="'cardNumClass'+index"  >

            <!--                  //  V-APP КОМПОНЕНТА   --  СДЕЛАННО НЕКОРPЕКТНО-->

            <StoredPageCard
                        :fileData="item"
                        :index="index"
                        @restore="restore"

                        :findingText="findingText"
                        @setHideCardIndex="setHideCardIndex"
            ></StoredPageCard>
<!--            :isEditableNow="isEditableNow"-->
<!--            @btnDel="btnDel"-->
<!--            @EditData="EditData"-->
<!--            @isEdit="isEdit"-->
<!--            :isDisabledCardIndex="isDisabledCardIndex"-->

        </v-container>
    </v-app>
</template>

<script>

import axios from "axios";

import StoredPageCard from './StoredPageCard';

export default {
  name: 'StoredPage',
    props: ['findingText', 'fButtonAddCardIsVisible'],

    components: {
        StoredPageCard,
    },

    data() {
        return {

            mString: [
                // {
                //     ID: -1
                //     FN: 'xx2',
                //     TEL: '+00000000002',
                //     EMAIL: 'xxx@xx2.com',
                // }
            ],
            //isDisabledCardIndex: null,
            // isEditableNow: false,
        }
    },

    methods:{

        // восстановит карту 'mString[i]'. переместить из одной базы в другую
        restore(i) {
            //console.log(i);

            axios.post("http://laravel-vue-cli-vuetify/api/restoreCard", {id: this.mString[i].ID})
                .then(res => {
                    //console.log(res.data.status)
                    //console.log(res.data.Card)
                    if(res.data.status == 'success---restoreCard'){
                        console.log(res.data.status)

                        this.mString.splice(i, 1)
                    }
                });
        },

        // Добавляем новую карту
        // btnAddCard(){
        //     //console.log('Console222222222');
        //     this.modalDialog = true;
        // },

        // Отменить Добавку новой карты
        // btnCancelAddCard(){
        //     //console.log('Console222222222');
        //     this.modalDialog = false;
        // },

        // confirmNewCardModal(){
        //     this.modalDialog = false;
        //
        //     // console.log( this.newCard.FN)
        //     // console.log( this.newCard.TEL)
        //     // console.log( this.newCard.EMAIL)
        //
        //     // если поля пустые -> обрабатываем их
        //     if(this.newCard.FN == undefined){
        //         this.newCard.FN = "none"
        //     }
        //     if(this.newCard.TEL == undefined){
        //         this.newCard.TEL = "none"
        //     }
        //     if(this.newCard.EMAIL == undefined){
        //         this.newCard.EMAIL = "none"
        //     }
        //
        //     if(this.newCard.FN != "none" ||
        //         this.newCard.TEL != "none" ||
        //         this.newCard.EMAIL != "none" ){
        //
        //         // добавить карту в базу данных
        //         axios.post("http://laravel-vue-cli-vuetify/api/addMewCard" , {newCard: this.newCard})
        //             .then(res => {
        //                     console.log(res.data.status)
        //                     //console.log(res.data.aaa)
        //                 if(res.data.status == "success---addMewCard") {
        //
        //                     axios.post("http://laravel-vue-cli-vuetify/api/loadDataFromBD", {isTime: 0})
        //                          .then(res => {
        //                              console.log(res.data.status)
        //                              //console.log(res.data.DataCards)
        //
        //                              // очищаем массив отображения и заново его заполняем с сервера
        //                              this.mString = [];
        //                              for(let i = 0; i < res.data.DataCards.length; i++){
        //                                  this.mString.push({
        //                                      ID: res.data.DataCards[i].id,
        //                                      FN: res.data.DataCards[i].name,
        //                                      TEL: res.data.DataCards[i].telephone,
        //                                      EMAIL: res.data.DataCards[i].email
        //                                  });
        //                              }
        //
        //                              // Сортировка по алфавиту имени 'FN'
        //                              this.mString.sort(function(a,b){
        //                                  let nameA=a.FN.toLowerCase();
        //                                  let nameB=b.FN.toLowerCase();
        //                                  if (nameA < nameB) return -1;
        //                                  if (nameA > nameB)  return 1;
        //                                  return 0
        //                              });
        //                              //this.mString = res.data.DataCards;
        //                              //console.log(this.mString)
        //
        //                              this.newCard.FN = undefined;
        //                              this.newCard.TEL = undefined;
        //                              this.newCard.EMAIL = undefined;
        //                          });
        //
        //                 }
        //             });
        //     }else{
        //         console.log('пусто')
        //         this.newCard.FN = undefined;
        //         this.newCard.TEL = undefined;
        //         this.newCard.EMAIL = undefined;
        //         return
        //     }
        // } ,

        // удаление из массива из дочернего компонента
        // btnDel(i){
        //     axios.post("http://laravel-vue-cli-vuetify/api/DeleteCardAndAddToStore" , {id: this.mString[i].ID})
        //         .then(res => {
        //             console.log(res.data.status)
        //             //console.log(res.data.card)
        //
        //             this.mString.splice(i, 1)
        //         });
        // },

        // переход на станицу редактирования данных
        // isEdit(i){
        //     this.isDisabledCardIndex = i;
        //     this.isEditableNow = true;
        // },

        // замена значения в массиве из дочернего компонента
        // EditData(i,FN,TEL,EMAIL){
        //     this.isDisabledCardIndex = null;
        //     this.isEditableNow = false;
        //     this.mString[i].FN = FN;
        //     this.mString[i].TEL = TEL;
        //     this.mString[i].EMAIL = EMAIL;
        //
        //     axios.post("http://laravel-vue-cli-vuetify/api/UpdateCard" , {
        //
        //         card: this.mString[i],
        //     })
        //         .then(res => {
        //             console.log(res.data.status)
        //             //console.log(res.data.fileData)
        //         });
        // } ,

        // делаем видимым-невидимым при поиске  (всем отрисованым элементам 'с классом' добавляем видимости или не...)
        setHideCardIndex(val, cardNumClass){
            if(cardNumClass== 'show'){
                document.querySelector(".cardNumClass"+val).classList.remove('hiddenCls');
            }
            else if(cardNumClass == 'hide'){
                document.querySelector(".cardNumClass"+val).classList.add('hiddenCls');
            }
            else if(cardNumClass == 'showAll'){
                this.mString.forEach(function(el, index){
                    document.querySelector(".cardNumClass"+index).classList.remove('hiddenCls');
                });
            }
        },

    },

    mounted() {

        console.log('mounted  ---  StoredPage')

        // делаем кнопку добавления карт НЕвидимой
        this.$emit('fButtonAddCardIsVisible', 0)

        // загружаем начальные данные в массив
        this.mString=[];
        axios.post("http://laravel-vue-cli-vuetify/api/loadDataFromStoreBD" , {})
            .then(res => {
                console.log(res.data.status)
                console.log(res.data.DataCards)

                // задаем массив для отображения
                for(let i =0; i< res.data.DataCards.length; i++){
                    this.mString.push({
                        ID: res.data.DataCards[i].id,
                        FN: res.data.DataCards[i].name,
                        TEL: res.data.DataCards[i].telephone,
                        EMAIL: res.data.DataCards[i].email
                    });
                }

                // Сортировка по алфавиту имени 'FN'
                this.mString.sort(function(a,b){
                    let nameA=a.FN.toLowerCase();
                    let nameB=b.FN.toLowerCase();
                    if (nameA < nameB) return -1;
                    if (nameA > nameB)  return 1;
                    return 0
                });
                //console.log(this.mString)



            });

    },
    updated() {
      console.log("updated  StoredPage")
    }

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

    .hiddenCls {
        /*visibility: hidden;*/
        display: none;
    }

</style>
