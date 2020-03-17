<template>
    <div>
        <div class="row">
            <div class="col-md-8">
                <h4>Список заблокированных пользователей</h4>
            </div>

            <div class="col-md-4 text-right">
                <button @click="addUserToBlocked()" class="btn btn-green"><i class="fa fa-edit"></i> Добавить</button>
            </div>

            <div class="col-md-12">
                <table class="table leads_table table-bordered table-striped">
                    <thead class="thead-light">
                        <th>#</th>
                        <th>Телефон</th>
                        <th>Заблокирован</th>
                        <th>Дата</th>
                    </thead>
                    <tbody>
                    <tr v-for="b_user in blocked_users">
                        <td>{{ b_user.id }}</td>
                        <td>{{ b_user.phone }}</td>
                        <td v-if="b_user.blocked == 1">Да</td>
                        <td v-else>Нет</td>
                        <td>{{ b_user.created_at }}</td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="blocked_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Заблокировать пользователя</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="phone">Введите телефон</label>
                                    <input type="text" id="phone" v-model="phone" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="LockUser()" class="btn btn-danger"><i class="fa fa-lock"></i>&nbsp;Заблокировать</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
export default {
    data(){
        return {
            phone: "",
            blocked_users: []
        }
    },
    methods: {
        addUserToBlocked(){
            $('#blocked_form').removeClass('fade').modal('toggle');
        },
        LockUser(){
            axios.post('/call_center/blocked-users', {
                _token: $("input[name='_token']").attr('content'),
                phone: this.phone
            })
            .then(res => {
                this.getBlockedUsers();
                $('#blocked_form').addClass('fade').modal('toggle');
            })
            .catch(err => {
                console.log(err)
            })
        },
        getBlockedUsers(){
            axios.get('/api/blocked-users')
            .then(res => {
                this.blocked_users = res.data.data;
            })
            .catch(err => {
                console.log(err)
            })
        }
    },
    created(){
        this.getBlockedUsers();
    }
}
</script>