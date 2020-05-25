<template>
    <v-app>
      <div class="LoadFilePage">
<!--        <h1>BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBbb</h1>-->

<!--          // загрузка файла-->

<!--            // Поиск текста-->
<!--          <v-text-field-->
<!--              label="Find"-->
<!--              v-model="findingText"-->
<!--              outlined-->
<!--              dense-->
<!--          ></v-text-field>-->

          <v-file-input
              accept=".-vcf-"
              label="Click here to select a .txt file"
              outlined
              v-model="chosenFile"
          >
          </v-file-input>

<!--          // кноки 'читать файл',  'сохранить'-->
          <v-row >
              <v-col cols="2">
                <v-btn right @click="importTxt">Read File</v-btn>
              </v-col>
              <v-col cols="2">
                <v-btn right @click="saveToServe">Save File</v-btn>
              </v-col>

          </v-row >


              <v-card-text v-if="data=='No File Chosen'"><p>{{data}}</p></v-card-text>

<!--                  <v-card-text v-for="(item, index) in mString" :key="index"><p>{{index}}: {{mString[index]}}</p></v-card-text>-->


<!--          -->
<!--          -->
          <div v-if="data!='No File Chosen'">
              <v-container  v-for="(item, index) in mString" :key="index" :class="'cardNumClass'+index"  >

<!--                  //  V-APP КОМПОНЕНТА   --  СДЕЛАННО НЕКОРPЕКТНО-->
                    <LoadFilePageCard :fileData="item"
                                      :index="index"
                                      :isDisabledCardIndex="isDisabledCardIndex"
                                      :isEditableNow="isEditableNow"
                                      @btnDel="btnDel"
                                      @EditData="EditData"
                                      @isEdit="isEdit"
                                      :findingText="findingText"
                                      @setHideCardIndex="setHideCardIndex"
                    ></LoadFilePageCard>
<!--                  :isFindedCard="isFindedCard"-->

              </v-container>

          </div>

      </div>


    </v-app>
</template>

<script>

import axios from "axios";

import LoadFilePageCard from './LoadFilePageCard';

export default {
  name: 'LoadFilePage',


    components: {
        LoadFilePageCard,
    },

    props: ['findingText', 'fButtonAddCardIsVisible'],
    data() {
        return {
            chosenFile: null,
            data: null,
            mStringTimer: [
                // {
                //     IDbd: -1
                //     FN: 'xx2',
                //     TEL: '+00000000002',
                //     EMAIL: 'xxx@xx2.com',
                // }
            ],
            mString: [
                // {
                //     ID: -1
                //     FN: 'xx2',
                //     TEL: '+00000000002',
                //     EMAIL: 'xxx@xx2.com',
                // }
            ],
            mStringEl: {
                FN: 'xx2',
                TEL: '+00000000002',
                EMAIL: 'xxx@xx2.com',
            },
            isDisabledCardIndex: null,
            isEditableNow: false,
            //findingText: ' ',
            //isFindedCard: false,

        }
    },

    methods: {


        // удаление из массива из дочернего компонента
        btnDel(i){
            axios.post("http://laravel-vue-cli-vuetify/api/DeleteCard" , {id: this.mString[i].ID})
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

        // сохранение на сервер  (данные с -1 удаляем а с 0 сохраняем)
        saveToServe(){
            console.log("--------save--------");
            //console.log( this.mString[0].FN);

            axios.post("http://laravel-vue-cli-vuetify/api/saveDataFromTimeData" , {})
                .then(res => {
                    console.log(res.data.status)

                    this.mString = [];
                    console.log('num:  ' + this.mString.length)
                });
        },

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


        // чтение из файла
        importTxt() {

            if (!this.chosenFile) {
                this.data = "No File Chosen"
            }else {
                var reader = new FileReader();
                reader.readAsText(this.chosenFile);
                reader.onload = () => {
                    this.data = reader.result;


                    //   обработка файла
                    let mStringTime = this.data.split('\n');      //  Cut  Text

                    for (let i = 0; i <= mStringTime.length - 1; i++) {

                        //this.sss = mStringTime;

                        // 111111111111111111111111111111111111111111
                        let str = mStringTime[i].indexOf('BEGIN:VCARD');
                        if (str != -1) {
                            this.mStringEl.FN = 'none';
                            this.mStringEl.TEL = 'none';
                            this.mStringEl.EMAIL = 'none';
                        }

                        // 22222222222222222222222222222222222222222
                        let strNum = mStringTime[i].indexOf('FN:');
                        if (strNum != -1) {
                            let strOrigin = mStringTime[i].trim();
                            strNum = strOrigin.indexOf(':');
                            let strResult = strOrigin.slice(strNum + 1);
                            if(!strResult==' '){
                                this.mStringEl['FN'] = strResult;
                            }
                            // console.log(str+"  ********* "+ strResult)
                        }

                        // 33333333333333333333333333333333333333333
                        strNum = mStringTime[i].indexOf('TEL;');
                        if (strNum != -1) {
                            let strOrigin = mStringTime[i].trim();
                            strNum = strOrigin.indexOf(':');
                            let strResult = strOrigin.slice(strNum + 1);
                            if(!strResult==' ') {
                                this.mStringEl['TEL'] = strResult;
                            }
                            //console.log(str+"  ********* "+ strResult)
                        }

                        // 4444444444444444444444444444444444444444
                        strNum = mStringTime[i].indexOf('EMAIL');
                        if (strNum != -1) {
                            let strOrigin = mStringTime[i].trim();
                            strNum = strOrigin.indexOf(':');
                            let strResult = strOrigin.slice(strNum + 1);
                            if(!strResult==' ') {
                                this.mStringEl['EMAIL'] = strResult;
                            }
                            //console.log(str+"  ********* "+ strResult)
                        }

                        // 5555555555555555555555555555555555555555
                        strNum = mStringTime[i].indexOf('END:VCARD');
                        if (strNum != -1) {

                            this.mStringTimer.push({
                                FN: this.mStringEl.FN,
                                TEL: this.mStringEl.TEL,
                                EMAIL: this.mStringEl.EMAIL
                            });

                        }
                    }
                     //console.log("uuuuuuuu")

                    // Сортировка по алфавиту имени 'FN'
                    this.mStringTimer.sort(function(a,b){
                        let nameA=a.FN.toLowerCase();
                        let nameB=b.FN.toLowerCase();
                        if (nameA < nameB) return -1;
                        if (nameA > nameB)  return 1;
                        return 0
                    });

                    //--------------------------------


                    // очищаем баду данных перед открытием нового файла

                    axios.post("http://laravel-vue-cli-vuetify/api/DeleteTimeData" , {})
                        .then(res => {
                            console.log(res.data.status)

                            // отправляю временный массив на сервер
                            axios.post("http://laravel-vue-cli-vuetify/api/saveTimeData" , {fileData: this.mStringTimer})
                                .then(res => {
                                    console.log(res.data.status)
                                    //console.log(res.data.fileData)


                                    // получаю с сервера данные о временных картах для отображения

                                    this.mStringTimer=[];
                                    this.mString=[];
                                    axios.post("http://laravel-vue-cli-vuetify/api/loadDataFromBD" , {isTime: -1})
                                        .then(res => {
                                            console.log(res.data.status)

                                            //console.log(res.data.file)
                                            for(let i =0; i< res.data.DataCards.length; i++){
                                                this.mString.push({
                                                    ID: res.data.DataCards[i].id,
                                                    FN: res.data.DataCards[i].name,
                                                    TEL: res.data.DataCards[i].telephone,
                                                    EMAIL: res.data.DataCards[i].email
                                                });
                                                //this.mString = res.data.DataCards

                                            }
                                            //console.log(this.mString)
                                        });
                                });
                        });


                }
            }




        } // importTxt()
    }, // methods:



    mounted: function() {
        console.log("--------mounted1111--------");
        // axios.post("http://laravel-vue-cli-vuetify/api/1" , {})
        //     .then(res => {
        //         console.log(res.data.status)
        //         console.log(res.data.file)
        //     });


        //// делаем кнопку добавления карт невидимой
        this.$emit('fButtonAddCardIsVisible', 0)

        // очистка временных значений с базы
        if(this.$route.params.id == undefined){
            axios.post("http://laravel-vue-cli-vuetify/api/DeleteTimeData" , {})
                .then(res => {
                    console.log(res.data.status)
                    //console.log('зззззззззззз-зззззззззззззззз-ppppppppppp')
                });
        }else {
            // испльзуется если ввесть 'path/:id' ищет в базе данные с индексом -1 и если они есть
            // открывает окно редактирования
            axios.post("http://laravel-vue-cli-vuetify/api/loadDataFromBD", {isTime: -1})
                .then(res => {
                    console.log(res.data.status)

                    //console.log(res.data.file)
                    for (let i = 0; i < res.data.DataCards.length; i++) {
                        this.mString.push({
                            ID: res.data.DataCards[i].id,
                            FN: res.data.DataCards[i].name,
                            TEL: res.data.DataCards[i].telephone,
                            EMAIL: res.data.DataCards[i].email
                        });
                        //this.mString = res.data.DataCards

                    }
                    //console.log(this.mString)


                    // если в адресной строке неправильные данные
                    if (this.$route.params.id != undefined && (this.mString.length == 0 || this.$route.params.id > this.mString.length)) {

                        this.$router.push({name: 'LoadFilePage'})
                    } else if (this.$route.params.id != undefined && this.mString.length > 0) {
                        //this.$emit('isEdit', this.$route.params.id)
                        this.isDisabledCardIndex = this.$route.params.id;
                        this.isEditableNow = true;
                        this.$router.push({name: 'LoadFilePageCardEdit', params: {id: this.$route.params.id}})
                    }
                });
        }

    },

    updated: function() {
        console.log("---------updated111----------");

    },

    destroyed: function() {
        console.log("---------destroyed111----------");

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
