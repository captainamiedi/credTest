<template>
    <div class="container">
        <Navbar signup="true" />
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="" v-if="error">
                    <p class="text-danger">{{error}}</p>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form autocomplete="off" @submit.prevent="submit">
                            <div class="form-group row">
                                <label for="name" class="col-md-3 col-form-label text-md-right">Name</label>

                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control" name="name" v-model="form.name" required  autofocus />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-3 col-form-label text-md-right">Email</label>

                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control" name="email" v-model="form.email" required autocomplete="email" autofocus />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-3 col-form-label text-md-right">Password</label>

                                <div class="col-md-8">
                                    <input id="password" type="password" class="form-control" name="password" v-model="form.password" required  autofocus />
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Sign Up
                                    </button>
                                </div>
                            </div>
                        </form>
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
        name: "Register",
        components: {Navbar},
        component: {
            Navbar
        },
        data() {
            return {
                form: {
                    email: '',
                    name: '',
                    password: '',
                    ref: ''
                },
                error: '',
            }
        },
        methods: {
            submit() {
                console.log(this.form)
                let refer = JSON.parse(localStorage.getItem('refer'));
                this.form.ref = refer;
                if (!this.form.email) {
                    this.error.push('Email is required')
                }
                if (!this.form.password){
                    this.error.push('Password id required')
                }
                if (!this.form.name){
                    this.error.push('name id required')
                }
                if (this.form.name && this.form.password && this.form.email) {
                    axios.post('http://localhost:8000/api/auth/register', this.form).then(res => {
                        // console.log(res)
                        const {data, status} = res;
                        if (status === 201) {
                            localStorage.setItem("user-token", JSON.stringify(data.token));
                            localStorage.removeItem('refer')
                            this.$router.push('/dashboard')
                        }
                    }).catch((err) => {
                        console.log(err)
                        this.error = err.response.data.message;
                    })
                }
            }
        }
    }
</script>

<style scoped>

</style>