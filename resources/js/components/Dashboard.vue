<template>
    <div class="container-fluid">
      <Navbar isLogin="true" />
        <h4 class="text-capitalize">Welcome {{walletBalance.users.name}}</h4>
        <p class="text-danger pt-1">Your password is your default pin</p>
        <p>Your Account number is <strong>{{acct.account_no}}</strong></p>
        <p v-if="walletBalance">Invite your friends via <strong>{{'http:localhost:8000/referer?ref='+ walletBalance.users.email}}</strong></p>

        <div class="row mx-1 py-2">
            <p class="mr-4">Account Balance</p>
            <strong v-if="walletBalance.balance">&#8358;{{walletBalance.balance}}</strong>
            <strong v-if="walletBalance === null">&#8358;0</strong>
        </div>

        <button class="btn btn-secondary" @click="modalOpen">Transfer</button>

        <div class="modal-dialog modal-dialog-centered" v-if="openModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Transfer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="modalOpen">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form autocomplete="off" @submit.prevent="transferFund">
                            <div class="form-group row">
                                <label for="name" class="col-md-3 col-form-label text-md-right">Receiver Account</label>

                                <div class="col-md-8">
                                    <input id="name" type="number" class="form-control" name="name" v-model="form.receiver_account" required  autofocus />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-3 col-form-label text-md-right">Amount</label>

                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control" name="number" v-model="form.withdraw_amount" required autocomplete="email" autofocus />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-3 col-form-label text-md-right">Pin</label>

                                <div class="col-md-8">
                                    <input id="password" type="password" class="form-control" name="password" v-model="form.pin" required  autofocus />
                                </div>
                            </div>
                            <div class="form-group row mb-0" v-if="error">
                                <div class="col-md-8 offset-md-4 text-danger">
                                    {{error}}
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="modalOpen">Close</button>
                        <button type="button" class="btn btn-primary" @click="transferFund">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Navbar from './Navbar'
    import axios from 'axios'
    export default {
        name: "Dashboard",
        components: {Navbar},
        component: {
            Navbar
        },
        data() {
            return {
                walletBalance: {},
                acct: {},
                openModal: false,
                form: {
                    receiver_account: '',
                    withdraw_amount: '',
                    pin: ''
                },
                error: ''
            }
        },
        methods: {
            balance() {
                // this is a temporary fix because of time
                let token = JSON.parse(localStorage.getItem("user-token"));
                let config = {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    }
                }
                axios.get('/api/wallet/balance', config).then(res => {
                    console.log(res.data[0][0])
                    this.walletBalance = res.data[0]
                }).catch(err => {
                    console.log(err)
                })
            },
            accountDetails() {
                // this is a temporary fix because of time
                let token = JSON.parse(localStorage.getItem("user-token"));
                let config = {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    }
                }
                axios.get('/api/account', config).then(res => {
                    console.log(res.data[0])
                    this.acct = res.data[0];
                }).catch(err => {
                    console.log(err)
                })
            },
            modalOpen() {
                this.openModal = !this.openModal;
            },
            transferFund() {
                if (!this.form.receiver_account) {
                    this.error = 'Receiver Account Number is required'
                }
                if (!this.form.pin){
                    this.error = 'Pin is required'
                }
                if (!this.form.withdraw_amount){
                    this.error = 'Amount to withdraw is required'
                }
                if (this.form.withdraw_amount && this.form.pin && this.form.receiver_account) {
                    // this is a temporary fix because of time
                    let token = JSON.parse(localStorage.getItem("user-token"));
                    let config = {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        }
                    }
                    axios.post('/api/transfer', this.form, config).then(res => {
                        console.log(res.data)
                        this.balance();
                        this.accountDetails()
                    }).catch(err => {
                        // console.log(err)
                        this.error = err.response.data.message;
                    })
                }
            }
        },
        created() {

            this.balance();
            this.accountDetails();
        }
    }
</script>

<style scoped>

</style>