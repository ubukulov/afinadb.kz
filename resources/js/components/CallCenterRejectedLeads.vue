<template>
    <div>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">НОВЫЕ ОТКАЗЫ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">ОБРАБОТАННЫЕ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">В ПРОЦЕССЕ</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <table class="table leads_table table-bordered table-striped">
                    <thead class="thead-light">
                    <th width="100">Дата</th>
                    <th width="100">Имя</th>
                    <th width="150">Телефон</th>
                    <th width="350">Комментарии</th>
                    <th width="200">Менеджер</th>
                    <th>Действие</th>
                    </thead>
                    <tbody>
                    <tr v-for="lead in rejectedLeads">
                        <td v-if="lead.dn == 0">{{ lead.dt + " #" + lead.id + " (сегодня)"  }}</td>
                        <td v-else-if="lead.dn == 1">{{ lead.dt + " #" + lead.id + " (вчера)" }}</td>
                        <td v-else="lead.dn > 1">{{ lead.dt + " #" + lead.id + " (" + lead.dn + ") дней"  }}</td>
                        <td>{{ lead.first_name }}</td>
                        <td>{{ lead.phone }}</td>
                        <td>{{ lead.comment }}</td>
                        <td>
                            <div class="status_btn">
                                <div>{{ lead.first_name + " " + lead.last_name }}</div>
                                <div class="_canceled"></div>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group" role="button">
                                <button title="Скрыть запрос" v-on:click="removeLead(lead.id)" class="btn btn-danger"><i class="fas fa-eye-slash"></i></button>
                                <button title="Вернуть обратно менеджеру" v-on:click="returnLeadForm(lead.id)" class="btn btn-primary"><i class="fas fa-undo"></i></button>
                                <button title="Комментарии" v-on:click="showComments(lead.id)" class="btn btn-success"><i class="far fa-comments"></i></button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <table class="table leads_table table-bordered table-striped">
                    <thead class="thead-light">
                    <th width="100">Дата</th>
                    <th width="100">Имя</th>
                    <th width="100">Телефон</th>
                    <th width="250">Комментарии</th>
                    <th width="200">Менеджер</th>
                    </thead>
                    <tbody>
                    <tr v-for="lead in completedLeads">
                        <td v-if="lead.dn == 0">{{ lead.dt + " #" + lead.id + " (сегодня)"  }}</td>
                        <td v-else-if="lead.dn == 1">{{ lead.dt + " #" + lead.id + " (вчера)" }}</td>
                        <td v-else="lead.dn > 1">{{ lead.dt + " #" + lead.id + " (" + lead.dn + ") дней"  }}</td>
                        <td>{{ lead.first_name }}</td>
                        <td>{{ lead.phone }}</td>
                        <td>{{ lead.comment }}</td>
                        <td>
                            <div class="status_btn">
                                <div>{{ lead.first_name + " " + lead.last_name }}</div>
                                <div class="_completed"></div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <table class="table leads_table table-bordered table-striped">
                    <thead class="thead-light">
                    <th width="100">Дата</th>
                    <th width="100">Имя</th>
                    <th width="100">Телефон</th>
                    <th width="250">Комментарии</th>
                    <th width="200">Менеджер</th>
                    </thead>
                    <tbody>
                    <tr v-for="lead in processingLeads">
                        <td v-if="lead.dn == 0">{{ lead.dt + " #" + lead.id + " (сегодня)"  }}</td>
                        <td v-else-if="lead.dn == 1">{{ lead.dt + " #" + lead.id + " (вчера)" }}</td>
                        <td v-else="lead.dn > 1">{{ lead.dt + " #" + lead.id + " (" + lead.dn + ") дней"  }}</td>
                        <td>{{ lead.first_name }}</td>
                        <td>{{ lead.phone }}</td>
                        <td>{{ lead.comment }}</td>
                        <td>
                            <div class="status_btn">
                                <div>{{ lead.first_name + " " + lead.last_name }}</div>
                                <div class="_processed"></div>
                            </div>
                            <div>
                                <button v-on:click="restoreLead(lead.id)" class="btn btn-primary processing">Восстановить запрос</button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modal_lead" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="exampleModalLongTitle">{{ modalTitle }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea placeholder="Ваш комментарий" v-model="comment" cols="30" rows="5" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-md-6 text-right">
                            <button v-on:click="closeForm()" class="btn btn-primary">Отмена</button>
                        </div>
                        <div class="col-md-6 text-right">
                            <button v-on:click="returnLead()" class="btn btn-danger">Вернуть запрос</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Comment Modal -->
        <div class="modal fade" id="modal_comment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="commentTitle">Комментарии</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="background: green url(/images/body_background.png); padding: 0px;">
                        <div style="background: rgba(255,255,255,0.7);">
                            <div class="row">
                                <div class="col-md-12" style="padding: 40px;">
                                    <div v-for="(com, i) in comments" style="background: #fff;padding: 10px;width: 100%;margin-bottom: 10px;border-radius: 20px;">
                                        <span style="font-weight: bold;"><i class="fas fa-user"></i>&nbsp;{{ com.name }}</span> <br>
                                        <span>{{ com.comment }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    export default {
        data(){
          return {
              rejectedLeads: [],
              completedLeads: [],
              processingLeads: [],
              modalTitle: "",
              lead_id: 0,
              comment: '',
              comments: [],
              j: false
          }
        },
        methods: {
            getRejectedLeads(){
                axios.get('/call_center/list/rejected-leads')
                    .then(res => {
                        this.rejectedLeads = res.data.data;
                        console.log(res);
                    })
                    .catch(err => {
                        console.log(err);
                    })
            },
            getCompletedLeads(){
                axios.get('/call_center/list/completed-leads')
                    .then(res => {
                        this.completedLeads = res.data.data;
                        console.log(res);
                    })
                    .catch(err => {
                        console.log(err);
                    })
            },
            getProcessedLeads(){
                axios.get('/call_center/list/processed-leads')
                    .then(res => {
                        this.processingLeads = res.data.data;
                        console.log(res);
                    })
                    .catch(err => {
                        console.log(err);
                    })
            },
            restoreLead(lead_id){
                if (confirm('Вы хотите восстановить запрос?')) {
                    axios.post('/call_center/lead/restore', {
                        lead_id: lead_id
                    })
                        .then(res => {
                            console.log(res);
                            this.getRejectedLeads();
                            this.getCompletedLeads();
                            this.getProcessedLeads();
                        })
                        .catch(err => {
                            console.log(err);
                        })
                }
            },
            removeLead(lead_id) {
                if (confirm("Вы хотите удалить запрос?")) {
                    axios.post('/call_center/lead/remove', {
                        lead_id: lead_id
                    })
                        .then(res => {
                            this.getRejectedLeads();
                            this.getCompletedLeads();
                            this.getProcessedLeads();
                            console.log(res);
                        })
                        .catch(err => {
                            console.log(err);
                        })
                }
            },
            returnLeadForm(lead_id){
                this.lead_id = lead_id;
                this.modalTitle = 'ЗАПРОС #'+lead_id;
                $('#modal_lead').removeClass('fade').modal('toggle');
            },
            returnLead(){
                if (this.comment.length !== 0) {
                    axios.post('/call_center/lead/return', {
                        lead_id: this.lead_id,
                        comment: this.comment
                    })
                        .then(res => {
                            this.getRejectedLeads();
                            this.getCompletedLeads();
                            this.getProcessedLeads();
                            $('#modal_lead').addClass('fade').modal('toggle');
                            console.log(res);
                        })
                        .catch(err => {
                            console.log(err);
                        })
                }
            },
            closeForm(){
                $('#modal_lead').addClass('fade').modal('toggle');
                this.comment = '';
            },
            showComments(lead_id){
                axios.post('/call_center/lead/comments', {
                    lead_id: lead_id
                })
                    .then(res => {
                        this.comments = res.data;
                        console.log(res.data);
                        console.log('sss', this.comments);
                        $('#modal_comment').removeClass('fade').modal('toggle');
                    })
                    .catch(err => {
                        console.log(err);
                    })
            }
        },
        created(){
            this.rejectedLeads = this.getRejectedLeads();
            this.completedLeads = this.getCompletedLeads();
            this.processingLeads = this.getProcessedLeads();
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
<style scoped>
    .processing {
        margin-top: 10px;
        -webkit-border-radius: 20px;
        -moz-border-radius: 20px;
        border-radius: 20px;
    }
</style>