<template>
    <div>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">В процессе</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Обработанные</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Необработанные</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <!-- В процессе -->
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <table class="table leads_table table-bordered table-striped">
                    <thead class="thead-light">
                    <th width="150">Дата</th>
                    <th width="150">Имя</th>
                    <th width="150">Тел</th>
                    <th width="250">Комментарии</th>
                    <th>Действие</th>
                    </thead>
                    <tbody>
                    <tr v-for="lead in processing_leads" v-bind:key="lead.id">
                        <td v-if="lead.dn == 0">{{ lead.dt + " #" + lead.id + " (сегодня)"  }}</td>
                        <td v-else-if="lead.dn == 1">{{ lead.dt + " #" + lead.id + " (вчера)" }}</td>
                        <td v-else="lead.dn > 1">{{ lead.dt + " #" + lead.id + " (" + lead.dn + ") дней"  }}</td>
                        <td>{{ lead.name }}</td>
                        <td>{{ lead.phone }}</td>
                        <td>{{ lead.comment }}</td>
                        <td>
                            <button title="Выполнено" v-on:click="completeLead(lead.id)" class="btn btn-primary"><i class="fas fa-check"></i></button>
                            <button title="Отказаться от запроса" v-on:click="cancelLeadForm(lead.id)" class="btn btn-danger"><i class="fas fa-times"></i></button>
                            <button title="Прослушать разговоры с клиентами" v-on:click="showAudioTalkWithCustomers(lead.phone)" class="btn btn-danger"><i class="fas fa-headphones"></i></button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Обработанные -->
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <table class="table leads_table table-bordered table-striped">
                    <thead class="thead-light">
                    <th width="100">Дата</th>
                    <th width="150">Имя</th>
                    <th width="150">Тел</th>
                    <th width="250">Комментарии</th>
                    <th width="100">Действие</th>
                    </thead>
                    <tbody>
                    <tr v-for="lead in completing_leads" v-bind:key="lead.id">
                        <td v-if="lead.dn == 0">{{ lead.dt + " #" + lead.id + " (сегодня)"  }}</td>
                        <td v-else-if="lead.dn == 1">{{ lead.dt + " #" + lead.id + " (вчера)" }}</td>
                        <td v-else="lead.dn > 1">{{ lead.dt + " #" + lead.id + " (" + lead.dn + ") дней"  }}</td>
                        <td>{{ lead.name }}</td>
                        <td>{{ lead.phone }}</td>
                        <td>{{ lead.comment }}</td>
                        <td>
                            <div class="btn-group">
                                <button title="Прослушать разговоры с клиентами" v-on:click="showAudioTalkWithCustomers(lead.phone)" class="btn btn-danger"><i class="fas fa-headphones"></i></button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Необработанные -->
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <table class="table leads_table table-bordered table-striped">
                    <thead class="thead-light">
                    <th width="100">Дата</th>
                    <th width="150">Имя</th>
                    <th width="150">Тел</th>
                    <th width="250">Комментарии</th>
                    <th width="100">Действие</th>
                    </thead>
                    <tbody>
                    <tr v-for="lead in canceling_leads" v-bind:key="lead.id">
                        <td v-if="lead.dn == 0">{{ lead.dt + " #" + lead.id + " (сегодня)"  }}</td>
                        <td v-else-if="lead.dn == 1">{{ lead.dt + " #" + lead.id + " (вчера)" }}</td>
                        <td v-else="lead.dn > 1">{{ lead.dt + " #" + lead.id + " (" + lead.dn + ") дней"  }}</td>
                        <td>{{ lead.name }}</td>
                        <td>{{ lead.phone }}</td>
                        <td>{{ lead.comment }}</td>
                        <td>
                            <div class="btn-group">
                                <button title="Комментарии" v-on:click="showComments(lead.id)" class="btn btn-success"><i class="far fa-comments"></i></button>
                                <button title="Прослушать разговоры с клиентами" v-on:click="showAudioTalkWithCustomers(lead.phone)" class="btn btn-danger"><i class="fas fa-headphones"></i></button>
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
                        <h5 class="modal-title" id="exampleModalLongTitle">{{ modalTitle }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div>
                                    <p>Этот запрос будет обработан Колл - Центром! В связи с этим просим Вас описать причину отказа в разделе комментарий.</p>
                                </div>
                                <div class="form-group">
                                    <label for="comment_id"></label>
                                    <textarea id="comment_id" cols="30" rows="5" class="form-control" v-model="comment"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-md-6 text-right">
                            <button v-on:click="closeForm()" class="btn btn-primary">Отмена</button>
                        </div>
                        <div class="col-md-6 text-right">
                            <button v-on:click="cancelLead()" class="btn btn-danger">Отказаться от запроса</button>
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

        <!-- Audio Talking Modal -->
        <div class="modal fade" id="modal_audio" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center">Список аудиозаписей</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="background: green url(/images/body_background.png); padding: 0px;">
                        <div style="background: rgba(255,255,255,0.7);">
                            <div class="row">
                                <div v-if="audio_talking.length > 0" class="col-md-12" style="padding: 40px;">
                                    <div v-for="(audio, i) in audio_talking" style="background: #fff;padding: 10px;width: 100%;margin-bottom: 10px;border-radius: 20px;">
                                        <span style="font-weight: bold;">
                                            <audio controls>
                                                <source v-bind:src="audio" type="audio/mpeg">
                                            </audio>
                                        </span>
                                    </div>
                                </div>
                                <div v-else="audio_talking.length == 0" class="col-md-12 text-center" style="padding: 40px;">
                                    <p style="font-size: 20px;">
                                        <i style="font-size: 40px;" class="fas fa-exclamation-triangle"></i> <br>
                                        Аудиозапись не найдено!
                                    </p>
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
                leads: [],
                processing_leads: [],
                completing_leads: [],
                canceling_leads : [],
                modalTitle: '',
                comment: '',
                comments: [],
                lead_id: 0,
                audio_talking: []
            }
        },
        methods: {
            getMyLeads() {
                axios.get('/director/my/leads')
                    .then(res => {
                        this.leads = res.data.data;
                        this.processing_leads = this.leads.filter(x => x.m_type === '1');
                        this.completing_leads = this.leads.filter(x => x.m_type === '0');
                        this.canceling_leads = this.leads.filter(x => x.m_type === '2');
                        console.log(res);
                    })
                    .catch(err => {
                        console.log(err);
                    })
            },
            completeLead(lead_id){
                if (confirm("Вы точно хотите закрыть запрос?")) {
                    axios.post('/director/change/lead/status', {
                        lead_id: lead_id,
                        process: 'complete'
                    })
                        .then(res => {
                            this.getMyLeads();
                            console.log(res);
                        })
                        .catch(err => {
                            console.log(err);
                        })
                }
            },
            cancelLead(){
                if (this.comment.length != '') {
                    axios.post('/director/change/lead/status', {
                        lead_id: this.lead_id,
                        process: 'cancel',
                        comment: this.comment
                    })
                        .then(res => {
                            this.getMyLeads();
                            console.log(res);
                            $('#modal_lead').addClass('fade').modal('toggle');
                        })
                        .catch(err => {
                            console.log(err);
                        })
                }
            },
            cancelLeadForm(lead_id){
                this.modalTitle = 'ПРИЧИНА ОТКАЗА ОТ ЗАПРОСА #' + lead_id;
                this.lead_id = lead_id;
                $('#modal_lead').removeClass('fade').modal('toggle');
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
                        $('#modal_comment').removeClass('fade').modal('toggle');
                    })
                    .catch(err => {
                        console.log(err);
                    })
            },
            showAudioTalkWithCustomers(phone){
                axios.post('/audio/talking-with-customers', {
                    phone: phone
                })
                    .then(res => {
                        this.audio_talking = res.data;
                        $('#modal_audio').removeClass('fade').modal('toggle');
                    })
                    .catch(err => {
                        console.log(err);
                    })
            }
        },
        created(){
            this.getMyLeads();
        }
    }
</script>