@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Projek Pemeriksaan Baharu</h2>
        <p class="text-gray-500 text-sm mt-1">Sila lengkapkan butiran hartanah klien di bawah.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded">
                <ul class="list-disc ml-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('inspection.store') }}" method="POST" enctype="multipart/form-data">
            @csrf 

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Tajuk Projek -->
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tajuk Projek / Nama Hartanah</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 outline-none" placeholder="Contoh: Pemeriksaan Teres 2 Tingkat" required>
                </div>

                <!-- Nama Klien -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Klien / Pemilik</label>
                    <input type="text" name="clientname" value="{{ old('clientname') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 outline-none" placeholder="Nama penuh klien" required>
                </div>

                <!-- Jenis Rumah -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Hartanah</label>
                    <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 outline-none bg-white" required>
                        <option value="" disabled selected>Pilih jenis...</option>
                        <option value="Teres Setingkat">Teres Setingkat</option>
                        <option value="Teres 2 Tingkat">Teres 2 Tingkat</option>
                        <option value="Semi-D">Semi-D</option>
                        <option value="Banglo">Banglo</option>
                        <option value="Kondominium / Apartment">Kondominium / Apartment</option>
                    </select>
                </div>

                <!-- Alamat -->
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Penuh</label>
                    <textarea name="address" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 outline-none" placeholder="Masukkan alamat lengkap..." required>{{ old('address') }}</textarea>
                </div>

                <!-- Negeri -->
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Negeri</label>
                    <select name="state" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 outline-none bg-white" required>
                        <option value="" disabled selected>Pilih negeri...</option>
                        <option value="Selangor">Selangor</option>
                        <option value="Kuala Lumpur">Kuala Lumpur</option>
                        <option value="Johor">Johor</option>
                        <option value="Pulau Pinang">Pulau Pinang</option>
                        <option value="Pahang">Pahang</option>
                    </select>
                </div>

                <!-- ================= 1. GAMBAR RUMAH (LANDSCAPE 4:3) ================= -->
                <div class="col-span-1 md:col-span-2 border-t border-gray-100 pt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Rumah (Muka Depan)</label>
                    <input type="file" id="imageInput" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    
                    <input type="hidden" name="cropped_image" id="croppedImageOutput">

                    <div id="cropperContainer" class="mt-4 hidden bg-gray-50 p-4 rounded-xl border border-dashed border-gray-300">
                        <div class="max-w-md mb-4 overflow-hidden">
                            <img id="imagePreview" src="" alt="Preview" class="max-h-72 block">
                        </div>
                        <div class="flex items-center">
                            <button type="button" id="cropButton" class="px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-lg hover:bg-emerald-700 shadow-sm">
                                <i class="fa-solid fa-crop mr-1"></i> Confirm Crop Gambar Rumah
                            </button>
                            <span id="cropStatus" class="ml-3 text-sm text-emerald-600 font-medium hidden">✓ Berjaya dipotong!</span>
                        </div>
                    </div>
                </div>

                <!-- ================= 2. PELAN LAYOUT (PORTRAIT / SEGI EMPAT KE ATAS 3:4) ================= -->
                <div class="col-span-1 md:col-span-2 border-t border-gray-100 pt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pelan Layout (Segi Empat Menegak / Ke Atas)</label>
                    <input type="file" id="layoutInput" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                    
                    <input type="hidden" name="cropped_layout" id="croppedLayoutOutput">

                    <div id="layoutCropperContainer" class="mt-4 hidden bg-gray-50 p-4 rounded-xl border border-dashed border-gray-300">
                        <div class="max-w-xs mb-4 overflow-hidden">
                            <img id="layoutPreview" src="" alt="Layout Preview" class="max-h-96 block">
                        </div>
                        <div class="flex items-center">
                            <button type="button" id="cropLayoutButton" class="px-4 py-2 bg-purple-600 text-white text-sm font-semibold rounded-lg hover:bg-purple-700 shadow-sm">
                                <i class="fa-solid fa-crop mr-1"></i> Confirm Crop Layout
                            </button>
                            <span id="layoutCropStatus" class="ml-3 text-sm text-purple-600 font-medium hidden">✓ Layout berjaya dipotong!</span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('dashboard') }}" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">Batal</a>
                <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm">Simpan Projek</button>
            </div>
        </form>
    </div>
</div>

<!-- Library Cropper.js -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // --- CROPPER UNTUK GAMBAR RUMAH (4:3) ---
        let cropper;
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');
        const cropperContainer = document.getElementById('cropperContainer');
        const cropButton = document.getElementById('cropButton');
        const croppedImageOutput = document.getElementById('croppedImageOutput');
        const cropStatus = document.getElementById('cropStatus');

        if(imageInput) {
            imageInput.addEventListener('change', function (e) {
                const files = e.target.files;
                if (files && files.length > 0) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        imagePreview.src = e.target.result;
                        cropperContainer.classList.remove('hidden');
                        cropStatus.classList.add('hidden');
                        cropButton.textContent = "Confirm Crop Gambar Rumah";
                        if (cropper) cropper.destroy();
                        cropper = new Cropper(imagePreview, { aspectRatio: 4 / 3, viewMode: 1 });
                    };
                    reader.readAsDataURL(files[0]);
                }
            });
        }

        if(cropButton) {
            cropButton.addEventListener('click', function () {
                if (cropper) {
                    const canvas = cropper.getCroppedCanvas({ width: 800, height: 600 });
                    croppedImageOutput.value = canvas.toDataURL('image/jpeg', 0.8);
                    cropStatus.classList.remove('hidden');
                    cropButton.textContent = "Crop Semula";
                }
            });
        }

        // --- CROPPER UNTUK PELAN LAYOUT (3:4 - Segi Empat Menegak Ke Atas) ---
        let layoutCropper;
        const layoutInput = document.getElementById('layoutInput');
        const layoutPreview = document.getElementById('layoutPreview');
        const layoutCropperContainer = document.getElementById('layoutCropperContainer');
        const cropLayoutButton = document.getElementById('cropLayoutButton');
        const croppedLayoutOutput = document.getElementById('croppedLayoutOutput');
        const layoutCropStatus = document.getElementById('layoutCropStatus');

        if(layoutInput) {
            layoutInput.addEventListener('change', function (e) {
                const files = e.target.files;
                if (files && files.length > 0) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        layoutPreview.src = e.target.result;
                        layoutCropperContainer.classList.remove('hidden');
                        layoutCropStatus.classList.add('hidden');
                        cropLayoutButton.textContent = "Confirm Crop Layout";
                        if (layoutCropper) layoutCropper.destroy();
                        // Aspek nisbah 3:4 (Menegak / Segi empat tepat ke atas)
                        layoutCropper = new Cropper(layoutPreview, { aspectRatio: 3 / 4, viewMode: 1 });
                    };
                    reader.readAsDataURL(files[0]);
                }
            });
        }

        if(cropLayoutButton) {
            cropLayoutButton.addEventListener('click', function () {
                if (layoutCropper) {
                    // Saiz keluaran ditetapkan menegak (600 lebar x 800 tinggi)
                    const canvas = layoutCropper.getCroppedCanvas({ width: 600, height: 800 });
                    croppedLayoutOutput.value = canvas.toDataURL('image/jpeg', 0.8);
                    layoutCropStatus.classList.remove('hidden');
                    cropLayoutButton.textContent = "Crop Semula";
                }
            });
        }
    });
</script>
@endsection