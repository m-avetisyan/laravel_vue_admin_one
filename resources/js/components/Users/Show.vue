<template>
    <div  v-if="user">
            <table class="table">
                <tr>
                    <th>ID</th>
                    <td>{{ user.id }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ user.name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ user.email }}</td>
                </tr>
                <tr>
                    <th>Role</th>
                    <td>{{ user.role }}</td>
                </tr>
            </table>
            <router-link to="/users">Back to all users</router-link>
            <div v-if="errors.length" class="alert alert-danger">
                <b>Please fix following errors</b>
                <ul>
                    <strong><li v-for="(error,index) in errors" :key="index">{{ error }}</li></strong>
                </ul>
            </div>
            <div class="alert alert-success"  v-if="invitation" >
                <b>Your invitation has been successfully sent.</b>
            </div>
            <form @submit.prevent="sendInvitation">
                <input type="email" placeholder="Member email" v-model="member_email"/>
                <input type="submit" value="Send Invitation Link" class="btn btn-primary">
            </form>
    </div>
</template>

<script>
    export default {
        name: 'show',
        mounted() {
                axios.get(`/api/users/${this.$route.params.id}`,{
                    headers:{
                        "Authorization":`Bearer ${this.currentUser.token}`
                    }
                })
                .then((response) => {
                    this.user = response.data.data
                });
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            },
        },
        data() {
            return {
                user: [],
                member_email:'',
                errors:[],
                invitation:false
            };
        },
        methods:{
            sendInvitation: function(e){
                this.errors = [];
                if (!this.member_email) {
                    this.errors.push('Member Email required.');
                } else if (!this.validEmail(this.member_email)) {
                    this.errors.push('Please provide valid email address.');
                }
                if (!this.errors.length) {
                    axios.post(`/api/user/sendInvitation`,{'member_email':this.member_email,'acc_id':this.user.id},{
                        headers:{
                            'Authorization':`Bearer ${this.currentUser.token}`
                        },
                    })
                    .then((response) => {
                        this.invitation = true
                    });
                }

                e.preventDefault();
            },
            validEmail: function (email) {
                var reg = /[^@]+@[^\.]+\..+/g;
                return reg.test(email);
            }
        },

    }
</script>
<style scoped>

    .user-view {
        display: flex;
        align-items: center;
    }

</style>
