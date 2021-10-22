<div id="sidebar" class="users p-chat-user showChat">
    <div class="had-container">
        <div class="p-fixed users-main">
            <div class="user-box">
                <div class="chat-search-box p-0">
                    <a class="back_friendlist">
                        <i class="feather icon-x"></i>
                    </a>
                </div>
                <div class="row p-2" id="right-bar">
                    <div class="col">
                        @can('update saldo')
                            <h6 class="my-2 text-center text">Tanggal: {{ \Carbon\Carbon::now()->format('d/M/Y') }}</h6>
                            <h6>
                                Update: {{ \Carbon\Carbon::parse(getSettingData('saldo')->updated_at)->format('d/M/Y') }}</h6>
                            <h6 class="my-1">Saldo Semen: {{  angkaTitikTiga(getSettingData('saldo')->value) }}</h6>
                            <div class="form-group row">
                                <div class="col-12 mb-1">
                                    {!! Form::number('set_saldo', getSettingData('saldo')->value, ['class' => 'form-control form-control-sm', 'id' => 'set-saldo', 'placeholder' => 'Isi nominal Saldo..']) !!}
                                </div>
                                <div class="col-12">
                                    <button id="btn-set-saldo"
                                            onclick="settSaldo('saldo', 'set-saldo', '{{ route("setting.update.value") }}')"
                                            class="btn btn-sm btn-info waves-effect waves-light btn-block"><i
                                            class="fa fa-money"></i> Update Saldo
                                    </button>
                                </div>
                            </div>
                            <hr>
                            <h6>
                                Update: {{ \Carbon\Carbon::parse(getSettingData('saldo_big_bag_opc')->updated_at)->format('d/M/Y') }}</h6>
                            <h6 class="my-1">Saldo Big Bag
                                OPC: {{  angkaTitikTiga(getSettingData('saldo_big_bag_opc')->value) }}</h6>
                            <div class="form-group row">
                                <div class="col-12 mb-1">
                                    {!! Form::number('set_saldo_big_bag_opc', getSettingData('saldo_big_bag_opc')->value, ['class' => 'form-control form-control-sm', 'id' => 'set-saldo-big-bag-opc', 'placeholder' => 'Isi nominal Saldo..']) !!}
                                </div>
                                <div class="col-12">
                                    <button id="btn-set-saldo"
                                            onclick="settSaldo('saldo_big_bag_opc', 'set-saldo-big-bag-opc', '{{ route("setting.update.value") }}')"
                                            class="btn btn-sm btn-info waves-effect waves-light btn-block"><i
                                            class="fa fa-money"></i> Update Saldo
                                    </button>
                                </div>
                            </div>
                            <hr>
                            <h6>
                                Update: {{ \Carbon\Carbon::parse(getSettingData('saldo_block_bottom_opc')->updated_at)->format('d/M/Y') }}</h6>
                            <h6 class="my-1">Saldo Block Bottom
                                OPC: {{  angkaTitikTiga(getSettingData('saldo_block_bottom_opc')->value) }}</h6>
                            <div class="form-group row">
                                <div class="col-12 mb-1">
                                    {!! Form::number('saldo_block_bottom_opc', getSettingData('saldo_block_bottom_opc')->value, ['class' => 'form-control form-control-sm', 'id' => 'set-saldo-block-bottom-opc', 'placeholder' => 'Isi nominal Saldo..']) !!}
                                </div>
                                <div class="col-12">
                                    <button id="btn-set-saldo"
                                            onclick="settSaldo('saldo_block_bottom_opc', 'set-saldo-block-bottom-opc', '{{ route("setting.update.value") }}')"
                                            class="btn btn-sm btn-info waves-effect waves-light btn-block"><i
                                            class="fa fa-money"></i> Update Saldo
                                    </button>
                                </div>
                            </div>
                            <hr>
                            <h6>
                                Update: {{ \Carbon\Carbon::parse(getSettingData('saldo_block_bottom_pcc')->updated_at)->format('d/M/Y') }}</h6>
                            <h6 class="my-1">Saldo Block Bottom
                                PCC: {{  angkaTitikTiga(getSettingData('saldo_block_bottom_pcc')->value) }}</h6>
                            <div class="form-group row">
                                <div class="col-12 mb-1">
                                    {!! Form::number('saldo_block_bottom_pcc', getSettingData('saldo_block_bottom_pcc')->value, ['class' => 'form-control form-control-sm', 'id' => 'set-saldo-block-bottom-pcc', 'placeholder' => 'Isi nominal Saldo..']) !!}
                                </div>
                                <div class="col-12">
                                    <button id="btn-set-saldo"
                                            onclick="settSaldo('saldo_block_bottom_pcc', 'set-saldo-block-bottom-pcc', '{{ route("setting.update.value") }}')"
                                            class="btn btn-sm btn-info waves-effect waves-light btn-block"><i
                                            class="fa fa-money"></i> Update Saldo
                                    </button>
                                </div>
                            </div>
                            <hr>
                        @endcan
                        <h5 class="mb-2 mt-1">Ganti Password</h5>
                        <div class="form-group row">
                            <div class="col-12 mb-1">
                                <input type="password" class="form-control form-control-sm" id="set-password-lama" name="set_password_lama" placeholder="Password Lama..">
                            </div>
                            <div class="col-12 mb-1">
                                <input type="password" class="form-control form-control-sm" id="set-password" name="set_password" placeholder="Password Baru.." onkeyup="checkPassword('#set-password','#set-re-password','#set-pass-pesan', '#btn-set-pass')">
                            </div>
                            <div class="col-12 mb-1">
                                <input type="password" class="form-control form-control-sm" id="set-re-password" name="re_password" placeholder="Ketik Ulang Password Baru.." onkeyup="checkPassword('#set-password','#set-re-password','#set-pass-pesan', '#btn-set-pass')">
                                <div class="col-form-label d-none" id="set-pass-pesan">
                                </div>
                            </div>
                            <div class="col-12">
                                <button id="btn-set-pass" disabled onclick="gantiPassword()" class="btn btn-sm btn-info waves-effect waves-light btn-block"><i class="fa fa-key"></i> Ganti Password</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
