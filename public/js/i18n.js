const i18n = {
    en: {
        title: "Alshamel Medical",
        subtitle: "Warehouse Management System (WMS) - Inventory Control",
        inventory_title: "Current Inventory",
        search_placeholder: "Search SKU or Batch...",
        th_product: "Product",
        th_warehouse: "Warehouse",
        th_batch: "Batch #",
        th_qty: "Qty",
        th_action: "Action",
        adjust_btn: "Adjust",
        api_monitor_title: "System Terminal (API Monitor)",
        history_title: "Adjustment History",
        th_date: "Date",
        th_reason: "Reason",
        th_diff: "Variance",
        th_note: "Note",
        fetch_batches: "Fetch Batches",
        fetch_reasons: "Fetch Reasons",
        fetch_history: "Fetch History",
        post_adjustment: "POST Adjustment",
        modal_title: "Adjust Inventory",
        lbl_batch: "Batch Number",
        lbl_product: "Product",
        lbl_warehouse: "Warehouse",
        lbl_current: "Current Stock",
        lbl_new_qty: "New Physical Quantity",
        lbl_reason: "Reason for Adjustment",
        lbl_note: "Additional Notes (Optional)",
        btn_cancel: "Cancel",
        btn_confirm: "Confirm Adjustment",
        btn_processing: "Processing...",
        github_btn: "View on GitHub",
        placeholder_qty: "Enter the exact physical count",
        placeholder_note: "Explain the discrepancy",
        variance: "Variance: ",
        loading_data: "Loading inventory data...",
        no_data: "No batches found",
        loading_history: "Loading history data...",
        no_history: "No adjustment history found",
        loading_reasons: "-- Select a reason --",
        msg_success: "Inventory adjusted successfully!",
        msg_error: "An error occurred",
        msg_failed_load: "Failed to load data.",
        api_desc_batches: "List all available batches",
        api_desc_reasons: "List adjustment reasons",
        api_desc_history: "View adjustment history",
        api_desc_post: "Create new adjustment",
        terminal_header: "Network Response"
    },
    zh: {
        title: "艾梅尔医疗",
        subtitle: "仓储管理系统 (WMS) - 库存控制",
        inventory_title: "当前库存",
        search_placeholder: "搜索 SKU 或 批次...",
        th_product: "产品",
        th_warehouse: "仓库",
        th_batch: "批次号",
        th_qty: "数量",
        th_action: "操作",
        adjust_btn: "盘点调整",
        api_monitor_title: "接口控制台",
        history_title: "库存调整记录",
        th_date: "日期",
        th_reason: "原因",
        th_diff: "差异",
        th_note: "备注",
        fetch_batches: "获取库存",
        fetch_reasons: "获取原因",
        fetch_history: "获取历史",
        post_adjustment: "提交调整",
        modal_title: "调整库存",
        lbl_batch: "批次号",
        lbl_product: "产品名称",
        lbl_warehouse: "所在仓库",
        lbl_current: "当前库存",
        lbl_new_qty: "最新盘点数量",
        lbl_reason: "调整原因",
        lbl_note: "附加备注 (选填)",
        btn_cancel: "取消",
        btn_confirm: "确认调整",
        btn_processing: "处理中...",
        github_btn: "在 GitHub 上查看",
        placeholder_qty: "请输入实际盘点的物理数量",
        placeholder_note: "请描述具体差异原因",
        variance: "差异: ",
        loading_data: "加载库存数据中...",
        no_data: "未找到任何批次",
        loading_history: "加载历史记录中...",
        no_history: "暂无调整历史",
        loading_reasons: "-- 请选择调整原因 --",
        msg_success: "库存调整成功！",
        msg_error: "发生异常",
        msg_failed_load: "数据加载失败。",
        api_desc_batches: "获取所有可用批次",
        api_desc_reasons: "获取所有调整原因",
        api_desc_history: "查看库存调整历史",
        api_desc_post: "创建新的库存调整",
        terminal_header: "网络响应"
    },
    ar: {
        title: "الشامل الطبية",
        subtitle: "نظام إدارة المستودعات - مراقبة المخزون",
        inventory_title: "المخزون الحالي",
        search_placeholder: "البحث عن رمز أو دفعة...",
        th_product: "المنتج",
        th_warehouse: "المستودع",
        th_batch: "رقم الدفعة",
        th_qty: "الكمية",
        th_action: "إجراء",
        adjust_btn: "تعديل",
        api_monitor_title: "مراقب الواجهة",
        history_title: "سجل التعديلات",
        th_date: "التاريخ",
        th_reason: "السبب",
        th_diff: "الفرق",
        th_note: "ملاحظات",
        fetch_batches: "جلب الدفعات",
        fetch_reasons: "جلب الأسباب",
        fetch_history: "جلب السجل",
        post_adjustment: "إرسال التعديل",
        modal_title: "تعديل المخزون",
        lbl_batch: "رقم الدفعة",
        lbl_product: "المنتج",
        lbl_warehouse: "المستودع",
        lbl_current: "المخزون الحالي",
        lbl_new_qty: "الكمية الفعلية الجديدة",
        lbl_reason: "سبب التعديل",
        lbl_note: "ملاحظات إضافية (اختياري)",
        btn_cancel: "إلغاء",
        btn_confirm: "تأكيد التعديل",
        btn_processing: "جاري المعالجة...",
        github_btn: "عرض على GitHub",
        placeholder_qty: "أدخل العد الفعلي الدقيق",
        placeholder_note: "اشرح التناقض",
        variance: "الفرق: ",
        loading_data: "جاري تحميل بيانات المخزون...",
        no_data: "لم يتم العثور على دفعات",
        loading_history: "جاري تحميل السجل...",
        no_history: "لا يوجد سجل تعديلات",
        loading_reasons: "-- اختر سبباً --",
        msg_success: "تم تعديل المخزون بنجاح!",
        msg_error: "حدث خطأ",
        msg_failed_load: "فشل في تحميل البيانات.",
        api_desc_batches: "سرد جميع الدفعات المتاحة",
        api_desc_reasons: "سرد أسباب التعديل",
        api_desc_history: "عرض سجل التعديلات",
        api_desc_post: "إنشاء تعديل جديد",
        terminal_header: "استجابة الشبكة"
    }
};

let currentLang = localStorage.getItem('app_lang');
if (!currentLang) {
    const browserLang = navigator.language.slice(0, 2);
    currentLang = i18n[browserLang] ? browserLang : 'en';
}

function setLanguage(lang) {
    if (!i18n[lang]) return;
    currentLang = lang;
    localStorage.setItem('app_lang', lang);
    
    // Set Direction
    document.documentElement.lang = lang;
    document.documentElement.dir = lang === 'ar' ? 'rtl' : 'ltr';
    
    // Update Text Elements
    document.querySelectorAll('[data-i18n]').forEach(el => {
        const key = el.getAttribute('data-i18n');
        if (i18n[lang][key]) {
            if ((el.tagName === 'INPUT' && (el.type === 'text' || el.type === 'number')) || el.tagName === 'TEXTAREA') {
                el.placeholder = i18n[lang][key];
            } else {
                el.innerHTML = i18n[lang][key];
            }
        }
    });

    // Fire event so app.js can re-fetch API data in correct language
    document.dispatchEvent(new CustomEvent('languageChanged', { detail: { lang } }));
}

// Add fetch interceptor to automatically append Accept-Language header
const originalFetch = window.fetch;
window.fetch = function() {
    let [resource, config] = arguments;
    if(config === undefined) config = {};
    if(config.headers === undefined) config.headers = {};
    
    // Convert Headers object to regular object if necessary, or just set it
    if (config.headers instanceof Headers) {
        config.headers.set('Accept-Language', currentLang);
    } else {
        config.headers['Accept-Language'] = currentLang;
    }
    
    return originalFetch(resource, config);
};

document.addEventListener('DOMContentLoaded', () => {
    // Inject Language Switcher Styles
    const style = document.createElement('style');
    style.innerHTML = `
        .lang-switcher { position: absolute; top: 1.5rem; inset-inline-end: 2rem; display: flex; gap: 0.5rem; z-index: 100; }
        .lang-btn { background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: white; padding: 0.4rem 0.8rem; border-radius: 2rem; cursor: pointer; transition: all 0.2s; font-size: 0.85rem; }
        .lang-btn:hover, .lang-btn.active { background: var(--accent-color); border-color: var(--accent-color); }
        @media (max-width: 768px) {
            .lang-switcher { position: static; justify-content: center; margin-bottom: 1rem; }
        }
    `;
    document.head.appendChild(style);

    // Inject UI Switcher
    const switcher = document.createElement('div');
    switcher.className = 'lang-switcher';
    switcher.innerHTML = `
        <button class="lang-btn ${currentLang === 'en' ? 'active' : ''}" onclick="setLanguage('en')">EN</button>
        <button class="lang-btn ${currentLang === 'zh' ? 'active' : ''}" onclick="setLanguage('zh')">中文</button>
        <button class="lang-btn ${currentLang === 'ar' ? 'active' : ''}" onclick="setLanguage('ar')">عربي</button>
    `;
    
    const container = document.querySelector('.container');
    container.insertBefore(switcher, container.firstChild);
    
    // Add active class toggler
    switcher.addEventListener('click', (e) => {
        if(e.target.classList.contains('lang-btn')) {
            document.querySelectorAll('.lang-btn').forEach(btn => btn.classList.remove('active'));
            e.target.classList.add('active');
        }
    });

    // Apply initial language
    setLanguage(currentLang);
});
