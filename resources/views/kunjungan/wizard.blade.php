<x-admin-layout>
    <x-slot name="title">Entri Kunjungan Baru</x-slot>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bx bx-plus-circle me-2"></i>
                        Wizard Entri Kunjungan LENTERA
                    </h5>
                </div>
                <div class="card-body" x-data="wizardForm()">
                    <!-- Progress Steps -->
                    <div class="d-flex justify-content-between mb-4 px-2">
                        <template x-for="(step, index) in steps" :key="index">
                            <div class="text-center flex-fill position-relative">
                                <div class="d-flex flex-column align-items-center">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-2"
                                         :class="currentStep > index ? 'bg-success' : (currentStep === index ? 'bg-primary' : 'bg-secondary')"
                                         style="width: 40px; height: 40px;">
                                        <template x-if="currentStep > index">
                                            <i class="bx bx-check text-white"></i>
                                        </template>
                                        <template x-if="currentStep <= index">
                                            <span class="text-white" x-text="index + 1"></span>
                                        </template>
                                    </div>
                                    <small class="d-none d-md-block" :class="currentStep === index ? 'fw-bold text-primary' : 'text-muted'" x-text="step"></small>
                                </div>
                                <div class="position-absolute top-50 start-50 w-100" style="z-index: -1; height: 2px;"
                                     :class="index < steps.length - 1 ? (currentStep > index ? 'bg-success' : 'bg-secondary') : ''"
                                     x-show="index < steps.length - 1"></div>
                            </div>
                        </template>
                    </div>

                    <form action="{{ route('kunjungan.store') }}" method="POST" @submit="handleSubmit">
                        @csrf
                        
                        <!-- Step 1: Identitas Anak -->
                        <div x-show="currentStep === 0" x-transition>
                            <h4 class="mb-1 text-center">
                                <i class="bx bx-user-circle text-primary"></i>
                                Meja 1: Pendaftaran
                            </h4>
                            <p class="text-center text-muted mb-4">Pilih data anak yang akan dikunjungi</p>

                            <div class="mb-3">
                                <label class="form-label">Tanggal Kunjungan</label>
                                <input type="date" name="tanggal_kunjungan" x-model="formData.tanggal_kunjungan" 
                                       class="form-control" required max="{{ date('Y-m-d') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Anak</label>
                                <select name="anak_id" x-model="formData.anak_id" @change="onAnakSelected" 
                                        class="form-select form-select-lg" required>
                                    <option value="">-- Pilih Anak --</option>
                                    @foreach($anaks as $anak)
                                        <option value="{{ $anak->id }}" 
                                                data-gender="{{ $anak->jenis_kelamin }}"
                                                data-birthdate="{{ $anak->tanggal_lahir->format('Y-m-d') }}"
                                                data-ibu="{{ $anak->ibu->nama ?? '-' }}"
                                                {{ isset($selectedAnak) && $selectedAnak->id == $anak->id ? 'selected' : '' }}>
                                            {{ $anak->nama }} ({{ $anak->jenis_kelamin_text }} - {{ $anak->usia_format }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div x-show="selectedAnak.nama" class="alert alert-info">
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-child bx-lg me-3"></i>
                                    <div>
                                        <strong x-text="selectedAnak.nama"></strong>
                                        <br>
                                        <small>
                                            <span x-text="selectedAnak.gender"></span> • 
                                            Usia: <span x-text="selectedAnak.usia"></span>
                                            <br>Ibu: <span x-text="selectedAnak.ibu"></span>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Antropometri -->
                        <div x-show="currentStep === 1" x-transition>
                            <h4 class="mb-1 text-center">
                                <i class="bx bx-ruler text-primary"></i>
                                Meja 2: Penimbangan
                            </h4>
                            <p class="text-center text-muted mb-4">Pengukuran berat badan, tinggi badan, dan lingkar kepala</p>

                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Berat Badan (kg) <span class="text-danger">*</span></label>
                                        <input type="number" step="0.1" name="berat_badan" x-model="formData.berat_badan"
                                               class="form-control form-control-lg text-center" 
                                               placeholder="8.5" required min="0.5" max="100">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tinggi/Panjang Badan (cm) <span class="text-danger">*</span></label>
                                        <input type="number" step="0.1" name="tinggi_badan" x-model="formData.tinggi_badan"
                                               class="form-control form-control-lg text-center" 
                                               placeholder="75.5" required min="30" max="200">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Lingkar Kepala (cm)</label>
                                        <input type="number" step="0.1" name="lingkar_kepala" x-model="formData.lingkar_kepala"
                                               class="form-control text-center" placeholder="45.0">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Lingkar Lengan (cm)</label>
                                        <input type="number" step="0.1" name="lingkar_lengan" x-model="formData.lingkar_lengan"
                                               class="form-control text-center" placeholder="14.5">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Analisa (Real-time calculation) -->
                        <div x-show="currentStep === 2" x-transition>
                            <h4 class="mb-1 text-center">
                                <i class="bx bx-analyse text-primary"></i>
                                Meja 3: Pencatatan
                            </h4>
                            <p class="text-center text-muted mb-4">Hasil analisa status gizi dan stunting</p>

                            <div x-show="isCalculating" class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Menghitung...</span>
                                </div>
                                <p class="mt-2 text-muted">Menghitung status gizi...</p>
                            </div>

                            <div x-show="!isCalculating && analysisResult">
                                <!-- Child Info -->
                                <div class="text-center mb-4">
                                    <h5 x-text="analysisResult?.anak?.nama"></h5>
                                    <p class="text-muted mb-0" x-text="analysisResult?.anak?.usia + ' • ' + analysisResult?.anak?.jenis_kelamin"></p>
                                    <p class="mb-0">
                                        <strong>BB:</strong> <span x-text="formData.berat_badan"></span> kg | 
                                        <strong>TB:</strong> <span x-text="formData.tinggi_badan"></span> cm
                                    </p>
                                </div>

                                <!-- Alert based on condition -->
                                <div x-show="analysisResult?.hasil?.alert_level === 'critical'" 
                                     class="alert alert-danger text-center">
                                    <i class="bx bx-error-circle bx-lg"></i>
                                    <h5 class="alert-heading mt-2">⚠️ PERHATIAN!</h5>
                                    <p class="mb-0">Anak ini memerlukan <strong>INTERVENSI SEGERA</strong>!</p>
                                </div>

                                <div x-show="analysisResult?.hasil?.alert_level === 'warning'" 
                                     class="alert alert-warning text-center">
                                    <i class="bx bx-error bx-lg"></i>
                                    <h5 class="alert-heading mt-2">Perlu Perhatian</h5>
                                    <p class="mb-0">Anak ini memerlukan pemantauan dan intervensi.</p>
                                </div>

                                <div x-show="analysisResult?.hasil?.alert_level === 'normal'" 
                                     class="alert alert-success text-center">
                                    <i class="bx bx-check-circle bx-lg"></i>
                                    <h5 class="alert-heading mt-2">Status Baik! ✅</h5>
                                    <p class="mb-0">Pertumbuhan anak dalam kondisi normal.</p>
                                </div>

                                <!-- Status Cards -->
                                <div class="row mt-4">
                                    <div class="col-12 col-md-4 mb-3">
                                        <div class="card h-100" :class="'border-' + (analysisResult?.hasil?.status_gizi?.color || 'secondary')">
                                            <div class="card-body text-center">
                                                <small class="text-muted">Status Gizi (BB/U)</small>
                                                <h5 class="mt-2" :class="'text-' + (analysisResult?.hasil?.status_gizi?.color || 'secondary')" 
                                                    x-text="analysisResult?.hasil?.status_gizi?.label || '-'"></h5>
                                                <small class="text-muted">
                                                    Z-Score: <span x-text="analysisResult?.hasil?.zscore?.bb_u || '-'"></span>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 mb-3">
                                        <div class="card h-100" :class="'border-' + (analysisResult?.hasil?.status_stunting?.color || 'secondary')">
                                            <div class="card-body text-center">
                                                <small class="text-muted">Status Stunting (TB/U)</small>
                                                <h5 class="mt-2" :class="'text-' + (analysisResult?.hasil?.status_stunting?.color || 'secondary')" 
                                                    x-text="analysisResult?.hasil?.status_stunting?.label || '-'"></h5>
                                                <small class="text-muted">
                                                    Z-Score: <span x-text="analysisResult?.hasil?.zscore?.tb_u || '-'"></span>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 mb-3">
                                        <div class="card h-100" :class="'border-' + (analysisResult?.hasil?.status_wasting?.color || 'secondary')">
                                            <div class="card-body text-center">
                                                <small class="text-muted">Status Wasting (BB/TB)</small>
                                                <h5 class="mt-2" :class="'text-' + (analysisResult?.hasil?.status_wasting?.color || 'secondary')" 
                                                    x-text="analysisResult?.hasil?.status_wasting?.label || '-'"></h5>
                                                <small class="text-muted">
                                                    Z-Score: <span x-text="analysisResult?.hasil?.zscore?.bb_tb || '-'"></span>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: Intervensi -->
                        <div x-show="currentStep === 3" x-transition>
                            <h4 class="mb-1 text-center">
                                <i class="bx bx-capsule text-primary"></i>
                                Meja 4: Penyuluhan & Pelayanan
                            </h4>
                            <p class="text-center text-muted mb-4">Pemberian Vitamin A, PMT, Imunisasi, dan Konseling</p>

                            <div class="row">
                                <!-- Vitamin A -->
                                <div class="col-12 col-md-6 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="form-check form-switch mb-2">
                                                <input type="checkbox" class="form-check-input" id="vitamin_a" 
                                                       name="vitamin_a" x-model="formData.vitamin_a" value="1">
                                                <label class="form-check-label fw-bold" for="vitamin_a">
                                                    <i class="bx bx-capsule text-danger"></i> Vitamin A
                                                </label>
                                            </div>
                                            <div x-show="formData.vitamin_a" class="mt-2">
                                                <select name="vitamin_a_dosis" x-model="formData.vitamin_a_dosis" class="form-select form-select-sm">
                                                    <option value="">Pilih Dosis</option>
                                                    <option value="biru">Kapsul Biru (100.000 IU)</option>
                                                    <option value="merah">Kapsul Merah (200.000 IU)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Obat Cacing -->
                                <div class="col-12 col-md-6 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input" id="obat_cacing" 
                                                       name="obat_cacing" x-model="formData.obat_cacing" value="1">
                                                <label class="form-check-label fw-bold" for="obat_cacing">
                                                    <i class="bx bx-first-aid text-warning"></i> Obat Cacing
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- PMT -->
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="form-check form-switch mb-2">
                                        <input type="checkbox" class="form-check-input" id="pmt" 
                                               name="pmt" x-model="formData.pmt" value="1">
                                        <label class="form-check-label fw-bold" for="pmt">
                                            <i class="bx bx-bowl-hot text-success"></i> PMT (Pemberian Makanan Tambahan)
                                        </label>
                                    </div>
                                    <div x-show="formData.pmt" class="row mt-2">
                                        <div class="col-6">
                                            <select name="jenis_pmt" x-model="formData.jenis_pmt" class="form-select form-select-sm">
                                                <option value="">Jenis PMT</option>
                                                <option value="biskuit">Biskuit MT</option>
                                                <option value="susu">Sop Ayam</option>
                                                <option value="makanan_lokal">Makanan Lokal</option>
                                                <option value="bubur">Bubur Kacang Hijau</option>
                                                <option value="telur">Telur</option>
                                                <option value="lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <input type="number" name="jumlah_pmt" x-model="formData.jumlah_pmt" 
                                                   class="form-control form-control-sm" placeholder="Jumlah">
                                        </div>
                                        <div class="col-3">
                                            <input type="text" name="satuan_pmt" x-model="formData.satuan_pmt" 
                                                   class="form-control form-control-sm" placeholder="Satuan">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Imunisasi -->
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6 class="mb-3">
                                        <i class="bx bx-injection text-info"></i> Imunisasi
                                    </h6>
                                    <div class="row">
                                        @php
                                            $imunisasiList = [
                                                'HB-0', 'BCG', 'Polio 1', 'Polio 2', 'Polio 3', 'Polio 4',
                                                'DPT-HB-Hib 1', 'DPT-HB-Hib 2', 'DPT-HB-Hib 3', 'IPV',
                                                'Campak/MR 1', 'Campak/MR 2', 'DPT-HB-Hib Lanjutan'
                                            ];
                                        @endphp
                                        @foreach($imunisasiList as $imun)
                                            <div class="col-6 col-md-4 mb-2">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" 
                                                           name="imunisasi[]" value="{{ $imun }}" id="imun_{{ Str::slug($imun) }}">
                                                    <label class="form-check-label" for="imun_{{ Str::slug($imun) }}">
                                                        {{ $imun }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Konseling -->
                            <div class="form-check form-switch mb-3">
                                <input type="checkbox" class="form-check-input" id="konseling_gizi" 
                                       name="konseling_gizi" x-model="formData.konseling_gizi" value="1">
                                <label class="form-check-label" for="konseling_gizi">
                                    <i class="bx bx-message-square-dots"></i> Konseling Gizi
                                </label>
                            </div>
                        </div>

                        <!-- Step 5: Validasi & Simpan -->
                        <div x-show="currentStep === 4" x-transition>
                            <h4 class="mb-1 text-center">
                                <i class="bx bx-check-shield text-primary"></i>
                                Meja 5: Validasi & Simpan
                            </h4>
                            <p class="text-center text-muted mb-4">Periksa kembali data sebelum menyimpan</p>

                            <div class="card bg-light mb-4">
                                <div class="card-body">
                                    <h6 class="mb-3">Ringkasan Data:</h6>
                                    <table class="table table-sm table-borderless mb-0">
                                        <tr>
                                            <td class="text-muted" width="40%">Nama Anak:</td>
                                            <td><strong x-text="selectedAnak.nama || '-'"></strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Tanggal Kunjungan:</td>
                                            <td x-text="formData.tanggal_kunjungan || '-'"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Berat Badan:</td>
                                            <td><span x-text="formData.berat_badan || '-'"></span> kg</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Tinggi Badan:</td>
                                            <td><span x-text="formData.tinggi_badan || '-'"></span> cm</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Status Gizi:</td>
                                            <td>
                                                <span class="badge" 
                                                      :class="'bg-' + (analysisResult?.hasil?.status_gizi?.color || 'secondary')"
                                                      x-text="analysisResult?.hasil?.status_gizi?.label || '-'"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Status Stunting:</td>
                                            <td>
                                                <span class="badge" 
                                                      :class="'bg-' + (analysisResult?.hasil?.status_stunting?.color || 'secondary')"
                                                      x-text="analysisResult?.hasil?.status_stunting?.label || '-'"></span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Catatan Tambahan</label>
                                <textarea name="catatan" x-model="formData.catatan" class="form-control" rows="3"
                                          placeholder="Catatan khusus tentang kunjungan ini..."></textarea>
                            </div>

                            <div class="alert alert-info">
                                <i class="bx bx-info-circle me-2"></i>
                                Pastikan semua data sudah benar sebelum menyimpan.
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                            <button type="button" class="btn btn-outline-secondary" 
                                    @click="prevStep" x-show="currentStep > 0">
                                <i class="bx bx-chevron-left"></i> Kembali
                            </button>
                            <div x-show="currentStep === 0"></div>

                            <button type="button" class="btn btn-primary" 
                                    @click="nextStep" x-show="currentStep < steps.length - 1"
                                    :disabled="!canProceed">
                                Lanjut <i class="bx bx-chevron-right"></i>
                            </button>

                            <button type="submit" class="btn btn-success btn-lg" 
                                    x-show="currentStep === steps.length - 1"
                                    :disabled="isSubmitting">
                                <template x-if="isSubmitting">
                                    <span class="spinner-border spinner-border-sm me-2"></span>
                                </template>
                                <i class="bx bx-save" x-show="!isSubmitting"></i>
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function wizardForm() {
            return {
                currentStep: 0,
                steps: ['Meja 1', 'Meja 2', 'Meja 3', 'Meja 4', 'Meja 5'],
                isCalculating: false,
                isSubmitting: false,
                analysisResult: null,

                formData: {
                    tanggal_kunjungan: '{{ date("Y-m-d") }}',
                    anak_id: '{{ $selectedAnak->id ?? "" }}',
                    berat_badan: '',
                    tinggi_badan: '',
                    lingkar_kepala: '',
                    lingkar_lengan: '',
                    vitamin_a: false,
                    vitamin_a_dosis: '',
                    obat_cacing: false,
                    pmt: false,
                    jenis_pmt: '',
                    jumlah_pmt: '',
                    satuan_pmt: '',
                    konseling_gizi: false,
                    catatan: '',
                },

                selectedAnak: {
                    nama: '{{ $selectedAnak->nama ?? "" }}',
                    gender: '{{ isset($selectedAnak) ? $selectedAnak->jenis_kelamin_text : "" }}',
                    usia: '{{ isset($selectedAnak) ? $selectedAnak->usia_format : "" }}',
                    ibu: '{{ isset($selectedAnak) && $selectedAnak->ibu ? $selectedAnak->ibu->nama : "" }}',
                    birthdate: '{{ isset($selectedAnak) ? $selectedAnak->tanggal_lahir->format("Y-m-d") : "" }}',
                },

                get canProceed() {
                    if (this.currentStep === 0) {
                        return this.formData.anak_id && this.formData.tanggal_kunjungan;
                    }
                    if (this.currentStep === 1) {
                        return this.formData.berat_badan && this.formData.tinggi_badan;
                    }
                    return true;
                },

                onAnakSelected() {
                    const select = document.querySelector('select[name="anak_id"]');
                    const option = select.options[select.selectedIndex];
                    if (option.value) {
                        this.selectedAnak = {
                            nama: option.text.split(' (')[0],
                            gender: option.dataset.gender === 'L' ? 'Laki-laki' : 'Perempuan',
                            usia: option.text.match(/\(([^)]+)\)/)?.[1] || '',
                            ibu: option.dataset.ibu,
                            birthdate: option.dataset.birthdate,
                        };
                    }
                },

                async nextStep() {
                    if (this.currentStep === 1) {
                        // Before moving to step 3, calculate status
                        await this.calculateStatus();
                    }
                    if (this.currentStep < this.steps.length - 1) {
                        this.currentStep++;
                    }
                },

                prevStep() {
                    if (this.currentStep > 0) {
                        this.currentStep--;
                    }
                },

                async calculateStatus() {
                    this.isCalculating = true;
                    try {
                        const response = await fetch('{{ route("api.calculate-status") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                anak_id: this.formData.anak_id,
                                berat_badan: this.formData.berat_badan,
                                tinggi_badan: this.formData.tinggi_badan,
                                tanggal_kunjungan: this.formData.tanggal_kunjungan,
                            }),
                        });
                        const data = await response.json();
                        if (data.success) {
                            this.analysisResult = data;
                        }
                    } catch (error) {
                        console.error('Error calculating status:', error);
                    } finally {
                        this.isCalculating = false;
                    }
                },

                handleSubmit(e) {
                    this.isSubmitting = true;
                    // Form will submit normally
                },
            };
        }
    </script>
    @endpush
</x-admin-layout>
