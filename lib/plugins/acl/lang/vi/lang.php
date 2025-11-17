<?php

/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
<<<<<<< HEAD
 * 
 * @author NukeViet <admin@nukeviet.vn>
 */
$lang['admin_acl']             = 'Quản lý danh sách quyền truy cập';
$lang['acl_group']             = 'Nhóm:';
$lang['acl_user']              = 'Thành viên:';
$lang['acl_perms']             = 'Cấp phép cho';
$lang['page']                  = 'Trang';
$lang['namespace']             = 'Thư mục';
$lang['btn_select']            = 'Chọn';
$lang['p_user_id']             = 'Thành viên <b class="acluser">%s</b> hiện tại được cấp phép cho trang <b class="aclpage">%s</b>: <i>%s</i>.';
$lang['p_user_ns']             = 'Thành viên <b class="acluser">%s</b>  hiện tại được cấp phép cho thư mục <b class="aclns">%s</b>: <i>%s</i>.';
$lang['p_group_id']            = 'Thành viên trong nhóm <b class="aclgroup">%s</b> hiện tại được cấp phép cho trang <b class="aclpage">%s</b>: <i>%s</i>.';
$lang['p_group_ns']            = 'Thành viên trong nhóm <b class="aclgroup">%s</b> hiện tại được cấp phép cho thư mục <b class="aclns">%s</b>: <i>%s</i>.';
$lang['p_choose_id']           = 'Hãy <b>nhập tên thành viên hoặc nhóm</b> vào ô trên đây để xem hoặc sửa quyền đã thiết đặt cho trang <b class="aclpage">%s</b>.';
$lang['p_choose_ns']           = 'Hãy <b>nhập tên thành viên hoặc nhóm</b> vào ô trên đây để xem hoặc sửa quyền đã thiết đặt cho thư mục <b class="aclns">%s</b>.';
$lang['p_inherited']           = 'Ghi chú: Có những quyền không được thể hiện ở đây nhưng nó được cấp phép từ những nhóm hoặc thư mục cấp cao.';
$lang['p_isadmin']             = 'Ghi chú: Nhóm hoặc thành viên này luôn được cấp đủ quyền vì họ là Quản trị tối cao';
$lang['p_include']             = 'Một số quyền thấp được thể hiện ở mức cao hơn. Quyền tạo, tải lên và xóa chỉ dành cho thư mục, không dành cho trang.';
$lang['current']               = 'Danh sách quyền truy cập hiện tại';
$lang['where']                 = 'Trang/Thư mục';
=======
 *
 * @author Thien Hau <thienhau.9a14@gmail.com>
 * @author NukeViet <admin@nukeviet.vn>
 */
$lang['admin_acl']             = 'Quản lý Danh sách kiểm soát truy cập';
$lang['acl_group']             = 'Nhóm:';
$lang['acl_user']              = 'Thành viên:';
$lang['acl_perms']             = 'Cấp quyền cho';
$lang['page']                  = 'Trang';
$lang['namespace']             = 'Không gian tên';
$lang['btn_select']            = 'Chọn';
$lang['p_user_id']             = 'Thành viên <b class="acluser">%s</b> hiện có các quyền sau trên trang <b class="aclpage">%s</b>: <i>%s</i>.';
$lang['p_user_ns']             = 'Thành viên <b class="acluser">%s</b> hiện có các quyền sau trong không gian tên <b class="aclns">%s</b>: <i>%s</i>.';
$lang['p_group_id']            = 'Thành viên trong nhóm <b class="aclgroup">%s</b> hiện có các quyền sau trên trang <b class="aclpage">%s</b>: <i>%s</i>.';
$lang['p_group_ns']            = 'Thành viên trong nhóm <b class="aclgroup">%s</b> hiện có các quyền sau trong không gian tên <b class="aclns">%s</b>: <i>%s</i>.';
$lang['p_choose_id']           = 'Hãy <b>nhập tên thành viên hoặc nhóm</b> vào mẫu trên đây để xem hoặc sửa đổi quyền đã thiết đặt cho trang <b class="aclpage">%s</b>.';
$lang['p_choose_ns']           = 'Hãy <b>nhập tên thành viên hoặc nhóm</b> vào mẫu trên đây để xem hoặc sửa đổi quyền đã thiết đặt cho không gian tên <b class="aclns">%s</b>.';
$lang['p_inherited']           = 'Ghi chú: Những quyền đó không được thể hiện rõ ràng nhưng được kế thừa từ những nhóm khác hoặc không gian tên cao hơn.';
$lang['p_isadmin']             = 'Ghi chú: Nhóm hoặc thành viên này luôn được cấp đủ quyền vì họ được đặt là Siêu thành viên';
$lang['p_include']             = 'Những quyền cao hơn bao gồm những quyền thấp hơn. Quyền Tạo, Tải lên và Xóa chỉ áp dụng cho không gian tên, không phải trang.';
$lang['current']               = 'Quy tắc Danh sách kiểm soát truy cập (ACL) hiện tại';
$lang['where']                 = 'Trang/Không gian tên';
>>>>>>> stable
$lang['who']                   = 'Thành viên/Nhóm';
$lang['perm']                  = 'Quyền';
$lang['acl_perm0']             = 'Không';
$lang['acl_perm1']             = 'Đọc';
<<<<<<< HEAD
$lang['acl_perm2']             = 'Sửa';
$lang['acl_perm4']             = 'Tạo';
$lang['acl_perm8']             = 'Tải lên';
$lang['acl_perm16']            = 'Xóa';
$lang['acl_new']               = 'Thêm mục mới';
$lang['acl_mod']               = 'Sửa';
=======
$lang['acl_perm2']             = 'Sửa đổi';
$lang['acl_perm4']             = 'Tạo';
$lang['acl_perm8']             = 'Tải lên';
$lang['acl_perm16']            = 'Xóa';
$lang['acl_new']               = 'Thêm mục nhập mới';
$lang['acl_mod']               = 'Sửa đổi mục nhập';
>>>>>>> stable
