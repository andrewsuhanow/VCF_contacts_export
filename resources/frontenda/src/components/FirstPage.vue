<template>
    <v-app>
  <div class="FirstPage">
    <h1>------Главная страница-------</h1>
<!--      <v-btn large color="primary">Primary</v-btn>-->
  </div>

        <v-container  v-for="(item, index) in mString" :key="index" :class="'cardNumClass'+index"  >

            <!--                  //  V-APP КОМПОНЕНТА   --  СДЕЛАННО НЕКОРPЕКТНО-->

<!--            :findingText="findingText"             //  текст вбитый в поиске-->
<!--            @setHideCardIndex="setHideCardIndex"   // видим - невидим, при поиске              -->
            <FirstPageCard
                        :fileData="item"
                        :index="index"
                        :isDisabledCardIndex="isDisabledCardIndex"
                        :isEditableNow="isEditableNow"
                        @btnDel="btnDel"
                        @EditData="EditData"
                        @isEdit="isEdit"
                        :findingText="findingText"
                        @setHideCardIndex="setHideCardIndex"
            ></FirstPageCard>
            <!--                  :isFindedCard="isFindedCard"-->

        </v-container>


пропущено место модального окна   НАЧАЛО    Этого быть недолжно
        <!--       модальное окно добавления новой карты    -->
        <v-row justify="center">
            <v-dialog v-model="modalDialog" persistent max-width="590">
                <v-card>
                    <v-card-title class="headline">Добавить контакт</v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field v-model="newCard.FN" label="Имя" required></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field v-model="newCard.TEL" label="Телефон" required></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field v-model="newCard.EMAIL" label="Email" required></v-text-field>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="white" text @click="btnCancelAddCard">Отмена</v-btn>
                        <v-btn color="white" text @click="confirmNewCardModal">Добавить</v-btn>
                        <!--                        <v-btn color="green darken-1" text @click="dialog = false">Agree</v-btn>-->
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
        пропущено место модального окна   КОНЕЦ    Этого быть недолжно


    </v-app>
</template>

<script>

import axios from "axios";

import FirstPageCard from './FirstPageCard';

export default {
  name: 'FirstPage',
    props: ['findingText', 'fButtonAddCardIsVisible'],

    components: {
        FirstPageCard,
    },

    data() {
        return {

            modalDialog: false,

            newCard: {
                //    FN: ''
                //    TEL: '+00000000002',
                //  EMAIL: 'xxx@xx2.com',
            },

            mString: [
                // {
                //     ID: -1
                //     FN: 'xx2',
                //     TEL: '+00000000002',
                //     EMAIL: 'xxx@xx2.com',
                // }
            ],
            isDisabledCardIndex: null,
            isEditableNow: false,
        }
    },

    methods:{


        // Добавляем новую карту
        btnAddCard(){
            //console.log('Console222222222');
            this.modalDialog = true;
        },

        // Отменить Добавку новой карты
        btnCancelAddCard(){
            //console.log('Console222222222');
            this.modalDialog = false;
        },

        confirmNewCardModal(){
            this.modalDialog = false;

            // console.log( this.newCard.FN)
            // console.log( this.newCard.TEL)
            // console.log( this.newCard.EMAIL)

            // если поля пустые -> обрабатываем их
            if(this.newCard.FN == undefined){
                this.newCard.FN = "none"
            }
            if(this.newCard.TEL == undefined){
                this.newCard.TEL = "none"
            }
            if(this.newCard.EMAIL == undefined){
                this.newCard.EMAIL = "none"
            }

            if(this.newCard.FN != "none" ||
                this.newCard.TEL != "none" ||
                this.newCard.EMAIL != "none" ){

                // добавить карту в базу данных
                axios.post("http://laravel-vue-cli-vuetify/api/addMewCard" , {newCard: this.newCard})
                    .then(res => {
                            console.log(res.data.status)
                            //console.log(res.data.aaa)
                        if(res.data.status == "success---addMewCard") {

                            axios.post("http://laravel-vue-cli-vuetify/api/loadDataFromBD", {isTime: 0})
                                 .then(res => {
                                     console.log(res.data.status)
                                     //console.log(res.data.DataCards)

                                     // очищаем массив отображения и заново его заполняем с сервера
                                     this.mString = [];
                                     for(let i = 0; i < res.data.DataCards.length; i++){
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
                                     //this.mString = res.data.DataCards;
                                     //console.log(this.mString)

                                     this.newCard.FN = undefined;
                                     this.newCard.TEL = undefined;
                                     this.newCard.EMAIL = undefined;
                                 });

                        }
                    });
            }else{
                console.log('пусто')
                this.newCard.FN = undefined;
                this.newCard.TEL = undefined;
                this.newCard.EMAIL = undefined;
                return
            }



        } ,

        // удаление из массива из дочернего компонента
        btnDel(i){
            axios.post("http://laravel-vue-cli-vuetify/api/DeleteCardAndAddToStore" , {id: this.mString[i].ID})
                .then(res => {
                    console.log(res.data.status)
                    //console.log(res.data.card)

                    this.mString.splice(i, 1)
                    //console.log(this.mString);


                    // стираем массив с данными и загружаем его наново

                    // this.mString = [];
                    // axios.post("http://laravel-vue-cli-vuetify/api/loadTimeDataFromBD" , {})
                    //     .then(res => {
                    //         console.log(res.data.status)
                    //
                    //         //console.log(res.data.file)
                    //         for(let i =0; i< res.data.DataCards.length; i++){
                    //             this.mString.push({
                    //                 ID: res.data.DataCards[i].id,
                    //                 FN: res.data.DataCards[i].name,
                    //                 TEL: res.data.DataCards[i].telephone,
                    //                 EMAIL: res.data.DataCards[i].email
                    //             });
                    //             //this.mString = res.data.DataCards
                    //
                    //         }
                    //         console.log(i+1)
                    //         // скролинг к месту открытой карточки
                    //         // let x = document.querySelector(".cardNumClass"+(i+1)).offsetLeft;
                    //         // let y = document.querySelector(".cardNumClass"+(i+1)).offsetTop;
                    //         // window.scrollTo(x,y)
                    //     });

                });
        },

        // переход на станицу редактирования данных
        isEdit(i){
            this.isDisabledCardIndex = i;
            this.isEditableNow = true;
        },

        // замена значения в массиве из дочернего компонента
        EditData(i,FN,TEL,EMAIL){
            this.isDisabledCardIndex = null;
            this.isEditableNow = false;
            this.mString[i].FN = FN;
            this.mString[i].TEL = TEL;
            this.mString[i].EMAIL = EMAIL;

            axios.post("http://laravel-vue-cli-vuetify/api/UpdateCard" , {

                card: this.mString[i],
            })
                .then(res => {
                    console.log(res.data.status)
                    //console.log(res.data.fileData)
                });
        } ,

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

        // делаем кнопку добавления карт видимой
        this.$emit('fButtonAddCardIsVisible', 1)

        // загружаем начальные данные в массив
        this.mString=[];
        axios.post("http://laravel-vue-cli-vuetify/api/loadDataFromBD" , {isTime: 0})
            .then(res => {
                console.log(res.data.status)

                // задаем массив для отображения
                for(let i =0; i< res.data.DataCards.length; i++){
                    this.mString.push({
                        ID: res.data.DataCards[i].id,
                        FN: res.data.DataCards[i].name,
                        TEL: res.data.DataCards[i].telephone,
                        EMAIL: res.data.DataCards[i].email
                    });
                    //this.mString = res.data.DataCards
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


                // если вводим индекс в адресную строку
                if (this.$route.params.id != undefined && (this.mString.length == 0 || this.$route.params.id > this.mString.length)) {
                    //console.log('1111111111111111111')
                    this.$router.push({name: 'FirstPage'})
                } else if (this.$route.params.id != undefined && this.mString.length > 0) {
                    //console.log('222222222222222')
                    //this.$emit('isEdit', this.$route.params.id)
                    this.isDisabledCardIndex = this.$route.params.id;
                    this.isEditableNow = true;
                    this.$router.push({name: 'FirstPageCardEdit', params: {id: this.$route.params.id}})
                }

            });

    },
    updated() {
      console.log("updated  First Page")
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
