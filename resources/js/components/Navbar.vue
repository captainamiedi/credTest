<template>
    <nav class="navbar navbar-light bg-primary mb-4">
        <a class="navbar-brand">Navbar</a>
        <form class="form-inline">
            <!--<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">-->
            <router-link to="/register">
                <button class="btn btn-outline-success my-2 my-sm-0" v-if="login">Register</button>
            </router-link>
            <router-link to="/login">
                <button class="btn btn-outline-success my-2 my-sm-0" v-if="signup">Login</button>
            </router-link>
            <button class="btn btn-outline-success my-2 my-sm-0" v-if="isLogin" @click="logout">Logout</button>
        </form>
    </nav>
</template>

<script>
    export default {
        name: "Navbar",
        props: {
            login: {
                type: String
            },
            signup: {
                type: String
            },
            isLogin : {
                type: String
            }
        },
        methods: {
            logout() {
                localStorage.removeItem('user-token')
                localStorage.clear();
            }
        }
    }
</script>

<style scoped>

</style>