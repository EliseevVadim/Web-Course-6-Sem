<template>
    <div>
        <div class="area row w-100 d-flex overflow-scroll bg-dark">
            <ul class="h-75 w-100 overflow-auto">
                <li v-for="message in messages">
                    <div class="chat-message" :class="message.additionalClass">
                        <b>{{message.sender}}</b>
                        <img class="img-fluid" :src="'/storage/images/' + message.image" alt="#" v-if="message.image !== undefined">
                        <span v-html="message.text"></span>
                        <div class="inline-keyboard" v-if="message.inline_keyboard !== undefined">
                            <button class="inline-button" v-for="button in message.inline_keyboard" v-if="button.url !== undefined" v-on:click="openInlineUrl(button.url)">{{button.text}}</button>
                            <button class="inline-button" v-for="button in message.inline_keyboard" v-if="button.callback_data !== undefined" v-on:click="sendInlineRequest(button.callback_data, message.inline_keyboard)">{{button.text}}</button>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="row d-flex flex-column text-center w-100">
            <form @submit.prevent="submit" class="d-flex justify-content-center">
                <div class="form-group d-flex w-75">
                    <input class="form-control" type="text" placeholder="Введите сообщение..." v-model="text">
                    <button class="sending-button btn btn-primary" type="submit">Отправить</button>
                </div>
            </form>
            <div class="row d-flex flex-column w-100 text-center keyboard">
                <button class="keyboard-button w-50" v-for="button in buttons" v-on:click="processKeyboardAction(button.text)">{{button.text}}</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "MessagesArea",
    data () {
        return {
            id : 0,
            text : "",
            messages: [

            ],
            buttons: [

            ]
        }
    },
    async created() {
        await this.getUserId().then(result => this.id = result);
    },
    methods: {
        async submit () {
            const config = {
                headers: {
                    'content-type': 'application/json',
                    'Accept': 'application/json'
                }
            }
            let toSend = {
                "message" : {
                    "message_id":1477,
                    "from" : {
                        "id":this.id,
                        "is_bot":false,
                        "first_name" : "Vadim",
                        "last_name" : "Eliseev",
                        "language_code" : "ru"
                    },
                    "chat" : {
                        "id": this.id,
                        "first_name": "Vadim",
                        "last_name": "Eliseev",
                        "type": "private"
                    },
                    "date" : 1647931474,
                    "text" : this.text
                }
            }
            axios.post('/telegram/handler', toSend, config)
                .then((response) => {
                    let usersObject = {
                        "text" : this.text
                    }
                    this.addMessage(false, usersObject);
                    this.addMessage(true, response.data);
                    this.text = "";
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        addMessage(fromServer, data) {
            let author = fromServer ? "Bot:" : "Me:"
            let additionalClass = fromServer ? "from-bot" : "from-user"
            let append = {
                "sender": author,
                "text": data.text,
                "inline_keyboard" : data.inline_keyboard,
                "image" : data.image,
                "additionalClass" : additionalClass
            }
            if (data.keyboard !== undefined) {
                this.buttons.splice(0, this.buttons.length);
                for (let i = 0; i < data.keyboard.length; i++) {
                    this.buttons.push(data.keyboard[i]);
                }
            }
            this.messages.push(append);
            setTimeout(this.scrollToBottomOfMessagesArea, 0.5);
        },
        scrollToBottomOfMessagesArea() {
            document.querySelector('ul').scrollTop = document.querySelector('ul').scrollHeight
        },
        openInlineUrl(url) {
            window.open(url, '_blank');
        },
        async sendInlineRequest(callback_data, buttons) {
            const config = {
                headers: {
                    'content-type': 'application/json',
                    'Accept': 'application/json'
                }
            }
            let toSend = {
                "message" : {
                    "message_id":1790,
                    "from" : {
                        "id":this.id,
                        "is_bot":false,
                        "first_name" : "Vadim",
                        "last_name" : "Eliseev",
                        "language_code" : "ru"
                    },
                    "chat" : {
                        "id": this.id,
                        "first_name": "Vadim",
                        "last_name": "Eliseev",
                        "type": "private"
                    },
                    "date" : 1647931474,
                    "text" : callback_data,
                    "reply_markup" : {
                        "inline_keyboard" : buttons
                    }
                }
            }
            axios.post('/telegram/handler', toSend, config)
                .then((response) => {
                    if (response.data.length === undefined) {
                        this.addMessage(true, response.data);
                        return;
                    }
                    for (let i = 0; i < response.data.length; i++) {
                        this.addMessage(true, response.data[i]);
                    }
                });
        },
        processKeyboardAction(command) {
            this.text = command;
            this.submit();
        },
        getUserId() {
            return axios.get('/getUserId')
                .then(response => {
                    return response.data.id;
                })
        }
    }
}
</script>

<style scoped>
    ul {
        padding: 0;
        max-height: 550px;
        height: 550px;
    }
    ul::-webkit-scrollbar {
        width: 0;
        height: 0;
    }
    li {
        list-style-type: none;
        padding-top: 5px;
        padding-bottom: 5px;
    }
    span, b {
        color: white;
    }
    .chat-message {
        display: flex;
        flex-direction: column;
        position: relative;
        padding: 30px;
        width: 30%;
    }
    .from-user {
        background: #8774e1;
        -moz-border-radius-topleft: 90px;
        -webkit-border-top-left-radius: 90px;
        border-top-left-radius: 90px;
        -moz-border-radius-bottomright: 90px;
        -webkit-border-bottom-right-radius: 90px;
        border-bottom-right-radius: 90px;
        -moz-border-radius-bottomleft: 90px;
        -webkit-border-bottom-left-radius: 90px;
        border-bottom-left-radius: 90px;
        left: 67%;
    }
    .from-bot {
        background: #212121;
        -moz-border-radius-topleft: 90px;
        -webkit-border-top-left-radius: 90px;
        border-top-left-radius: 90px;
        -moz-border-radius-topright: 90px;
        -webkit-border-top-right-radius: 90px;
        border-top-right-radius: 90px;
        -moz-border-radius-bottomright: 90px;
        -webkit-border-bottom-right-radius: 90px;
        border-bottom-right-radius: 90px;
        left: 3%;
    }
    button.inline-button {
        width: 100%;
        background: rgba(29, 65, 226, 0.4);
        color: white;
        border-radius: 10px;
        margin-top: 5px;
        margin-bottom: 5px;
        border: none;
        font-weight: bolder;
        outline: none;
    }
    button.keyboard-button {
        color: white;
        border: 1px solid transparent;
        border-radius: 10px;
        background: #6f42c1;
        outline: none;
        margin-top: 5px;
        margin-bottom: 5px;
    }
    .area {
        min-height: 550px;
    }
    .sending-button {
        opacity: 1;
        display: block;
    }
    .keyboard {
        align-items: center;
    }
</style>
