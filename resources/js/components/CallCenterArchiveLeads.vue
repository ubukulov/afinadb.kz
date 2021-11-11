<template>
    <div>
        <nav aria-label="...">
            <ul class="pagination">
                <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                    <a class="page-link" v-on:click="getLeads(pagination.prev_page_url)" href="#" tabindex="-1">Предыдущая</a>
                </li>
                <li class="page-item" v-for="page in pagination.last_page" v-bind:class="[{ disabled: page == pagination.current_page}]">
                    <a v-if="page <= 10" class="page-link" href="#" v-on:click="getLeads(page)">
                        {{ page }}
                        <span v-if="page == pagination.current_page" class="sr-only">(current)</span>
                    </a>
                </li>

                <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                    <a class="page-link" v-on:click="getLeads(pagination.next_page_url)" href="#">Следующая</a>
                </li>
            </ul>
        </nav>
        <table class="table leads_table table-bordered table-striped">
            <thead class="thead-light">
            <th width="150">Дата</th>
            <th width="100">Имя</th>
            <th width="150">Телефон</th>
            <th width="150">Город</th>
            <th width="350">Комментарии</th>
            <th width="200">Менеджер</th>
            <th>Действие</th>
            </thead>
            <tbody>
            <tr v-for="lead in leads">
                <td v-if="lead.dn == 0">{{ lead.dt + " #" + lead.id + " (сегодня)"  }}</td>
                <td v-else-if="lead.dn == 1">{{ lead.dt + " #" + lead.id + " (вчера)" }}</td>
                <td v-else="lead.dn > 1">{{ lead.dt + " #" + lead.id + " (" + lead.dn + ") дней"  }}</td>
                <td>{{ lead.name }}</td>
                <td>{{ lead.phone }}</td>
                <td>{{ lead.city_name }}</td>
                <td>{{ lead.comment }}</td>
                <td>
                    <div class="status_btn">
                        <div>{{ lead.user_name + " " + lead.last_name }}</div>
                        <div class="_canceled"></div>
                    </div>
                </td>
                <td>
                    <div class="btn-group" role="button">
                        <button title="Комментарии" v-on:click="showComments(lead.id)" class="btn btn-success"><i class="far fa-comments"></i></button>
                        <button title="Прослушать разговоры с клиентами" v-on:click="showAudioTalkWithCustomers(lead.phone)" class="btn btn-danger"><i class="fas fa-headphones"></i></button>
                        <button title="Сделать запрос новыми" v-on:click="setLeadNew(lead.id)" class="btn btn-success"><i class="fas fa-external-link-square-alt"></i></button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

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
                                        <span style="font-weight: bold;"><i class="fas fa-clock"></i>&nbsp;{{ $moment.unix(com.seconds).format("DD.MM.YYYY, HH:mm:ss") }}</span> <br>
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
        data() {
            return {
                leads: [],
                pagination: {},
                audio_talking: [],
                comments: [],
            }
        },
        methods: {
            getArchiveLeads(){
                axios.get('/api/archive/leads')
                    .then(res => {
                        this.leads = res.data.data;
                        this.makePagination(res.data.links, res.data.meta);
                    })
                    .catch(err => {
                        console.log(err);
                    })
            },
            getLeads(url){
                url = url || "/api/archive/leads";
                if (typeof url === 'number') {
                    url = "/api/archive/leads?page="+url;
                }
                axios.get(url)
                    .then(response => {
                        this.leads = response.data.data;
                        this.makePagination(response.data.links, response.data.meta);
                    })
                    .catch(e => {
                        console.log(e);
                    })
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
            },
            makePagination(links, meta){
                let pagination;
                pagination = {
                    prev_page_url: links.prev,
                    next_page_url: links.next,
                    last_page_url: links.last,
                    first_page_url: links.first,
                    current_page: meta.current_page,
                    last_page: meta.last_page
                };
                this.pagination = pagination;
                console.log(pagination);
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
            },
            setLeadNew(lead_id) {
                if (confirm("Вы хотите вернуть в раздел запросы?")) {
                    axios.post('/call_center/set/lead/new', {
                        lead_id: lead_id
                    })
                        .then(res => {
                            console.log(res);
                            this.getArchiveLeads();
                        })
                        .catch(err => {
                            console.log(err);
                        })
                }
            }
        },
        created() {
            this.getArchiveLeads();
        }
    }
</script>
