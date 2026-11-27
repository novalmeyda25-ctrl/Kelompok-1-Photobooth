
document.addEventListener('DOMContentLoaded', function () {

    // =========================================
    // 1. ELEMENT HTML
    // =========================================

    const carouselTrack = document.getElementById('carousel-track');

    const selectedInput = document.getElementById('selected-frame-id');

    const nextButton = document.getElementById('btn-use-frame');

    const selectedLabel = document.getElementById('lbl-selected-frame');

    const message = document.getElementById('frame-selection-message');

    const form = document.getElementById('frame-selection-form');

    if (!carouselTrack || !selectedInput || !nextButton || !form) {
        return;
    }


    // =========================================
    // 2. DATA TEMPLATE
    // =========================================

    const templateList = window.WBTpl
        ? window.WBTpl.list()
        : [];

    const templateById = {};

    templateList.forEach(function (template) {
        templateById[template.id] = template;
    });


    // =========================================
    // 3. CLASS KARTU FRAME
    // =========================================

    const CARD_BASE =
        'frame-card flex-1 min-w-[270px] sm:min-w-[290px] p-4 rounded-3xl border border-[#FBCFE8] bg-white hover:border-[#BE185D]/60 shadow-sm cursor-pointer transition-all duration-300 flex flex-col justify-between';

    const CARD_ACTIVE =
        'frame-card flex-1 min-w-[270px] sm:min-w-[290px] p-4 rounded-3xl border-2 border-[#BE185D] bg-[#FFE4E8]/50 shadow-[0_8px_24px_rgba(244,114,182,0.22)] cursor-pointer transition-all duration-300 transform scale-[1.03] flex flex-col justify-between';


    // =========================================
    // 4. HTML ESCAPE
    // =========================================

    function esc(value) {

        const element = document.createElement('div');

        element.textContent = value == null
            ? ''
            : String(value);

        return element.innerHTML;
    }


    // =========================================
    // 5. BADGE JUMLAH FOTO
    // =========================================

    function addCountBadge(card, template) {

        const thumb = card.firstElementChild;

        if (!thumb || thumb.querySelector('.wb-count-badge')) {
            return;
        }

        const badge = document.createElement('span');

        badge.className =
            'wb-count-badge absolute top-3 right-3 z-10 px-2.5 py-1 rounded-full bg-white/90 text-[#970046] text-[10.5px] font-bold shadow-xs border border-[#FBCFE8]';

        badge.textContent = `${template.slots.length} foto`;

        thumb.classList.add('relative');

        thumb.appendChild(badge);
    }


    // =========================================
    // 6. MEMBUAT KARTU TEMPLATE DINAMIS
    // =========================================

    function buildCard(template) {

        const card = document.createElement('div');

        card.className = CARD_BASE;

        card.dataset.templateId = template.id;

        card.dataset.frameName = template.name;

        let thumbnail;

        if (template.kind === 'image') {

            thumbnail = `
                <img
                    src="${esc(template.image)}"
                    alt="${esc(template.name)}"
                    draggable="false"
                    class="max-h-full w-auto object-contain rounded-md shadow-lg select-none">
            `;

        } else {

            const slots = template.slots.map(function () {

                return `
                    <div class="flex-1 rounded-md bg-white/80 border border-white"></div>
                `;

            }).join('');

            thumbnail = `
                <div class="h-full w-20 py-1 flex flex-col gap-1.5">
                    ${slots}
                </div>
            `;
        }

        const background = template.accent ||
            'radial-gradient(circle at 35% 30%, #FFE4E8 0%, #FBCFE8 50%, #FDA4AF 100%)';

        card.innerHTML = `
            <div
                class="w-full h-52 rounded-2xl relative overflow-hidden flex items-center justify-center p-3 border border-white/60 shadow-inner"
                style="background:${background}">

                ${thumbnail}

            </div>

            <div class="mt-4 px-1 text-left">

                <p class="text-[17px] font-bold text-[#211a1b]">
                    ${esc(template.name)}
                </p>

                <p class="text-[13px] text-[#594046] mt-0.5">
                    ${esc(template.tagline || (template.slots.length + ' foto'))}
                </p>

            </div>
        `;

        return card;
    }


    // =========================================
    // 7. MEMILIH FRAME
    // =========================================

    function selectFrame(card, template) {

        // Kembalikan semua kartu ke tampilan normal
        carouselTrack.querySelectorAll('.frame-card').forEach(function (item) {

            item.className = CARD_BASE;

            item.querySelectorAll('.material-symbols-outlined')
                .forEach(function (icon) {

                    if (icon.innerText.trim() === 'check_circle') {
                        icon.remove();
                    }

                });

        });

        // Tandai kartu terpilih
        card.className = CARD_ACTIVE;

        // Simpan ID template
        selectedInput.value = template.id;

        // Tampilkan nama frame
        if (selectedLabel) {
            selectedLabel.textContent = template.name;
        }

        // Aktifkan tombol lanjut
        nextButton.disabled = false;

        if (message) {
            message.textContent =
                'Frame ' + template.name + ' berhasil dipilih.';
        }

    }


    // =========================================
    // 8. INISIALISASI KARTU FRAME
    // =========================================

    function initFrameSelection() {

        if (!templateList.length) {

            console.error('Daftar template tidak ditemukan.');

            nextButton.disabled = true;

            return;
        }

        // Hapus kartu yang ID-nya tidak tersedia
        carouselTrack.querySelectorAll(
            '.frame-card[data-template-id]'
        ).forEach(function (card) {

            if (!templateById[card.dataset.templateId]) {
                card.remove();
            }

        });

        // Buat atau gunakan kartu berdasarkan data template
        templateList.forEach(function (template) {

            let card = carouselTrack.querySelector(
                `.frame-card[data-template-id="${template.id}"]`
            );

            // Buat kartu jika belum tersedia di HTML
            if (!card) {

                card = buildCard(template);

                carouselTrack.appendChild(card);

            }

            // Tambahkan informasi jumlah slot
            addCountBadge(card, template);

            // Event ketika kartu diklik
            card.addEventListener('click', function () {

                selectFrame(this, template);

            });

        });

        // Tidak ada frame yang dipilih otomatis
        selectedInput.value = '';

        nextButton.disabled = true;

        if (selectedLabel) {
            selectedLabel.textContent = 'Belum dipilih';
        }

    }


    // =========================================
    // 9. VALIDASI FORM
    // =========================================

    form.addEventListener('submit', function (event) {

        if (!selectedInput.value || !templateById[selectedInput.value]) {

            event.preventDefault();

            alert('Silakan pilih frame terlebih dahulu.');

            return;
        }

    });


    // =========================================
    // 10. NAVIGASI CAROUSEL
    // =========================================

    document.getElementById('carousel-prev')
        ?.addEventListener('click', function () {

            carouselTrack.scrollBy({
                left: -320,
                behavior: 'smooth'
            });

        });

    document.getElementById('carousel-next')
        ?.addEventListener('click', function () {

            carouselTrack.scrollBy({
                left: 320,
                behavior: 'smooth'
            });

        });


    // =========================================
    // 11. JALANKAN
    // =========================================

    initFrameSelection();

});
