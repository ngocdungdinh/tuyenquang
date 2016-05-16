<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

return array(

	'Truy cập quản trị' => array(
		array(
			'permission' => 'admin',
			'label'      => 'Truy cập quản trị',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'deletecache',
			'label'      => 'Xóa cache',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'viewanalytics',
			'label'      => 'Xem thống kê truy cập',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'news.sort',
			'label'      => 'Sắp xếp bài viết',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'user.online',
			'label'      => 'Thành viên Online',
			'type'      => 'sconf',
		),
	),
	'Người dùng' => array(
		array(
			'permission' => 'user.full',
			'label'      => 'Toàn quyền',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'user.create',
			'label'      => 'Tạo người dùng',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'user.edit',
			'label'      => 'Sửa người dùng',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'user.permission',
			'label'      => 'Phân quyền',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'user.detele',
			'label'      => 'Xóa người dùng',
			'type'      => 'sconf',
		)
	),
	'Nhóm người dùng' => array(
		array(
			'permission' => 'group.full',
			'label'      => 'Toàn quyền',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'group.create',
			'label'      => 'Tạo nhóm người dùng',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'group.edit',
			'label'      => 'Sửa nhóm người dùng',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'group.detele',
			'label'      => 'Xóa nhóm người dùng',
			'type'      => 'sconf',
		)
	),
	'Tin tức' => array(
		array(
			'permission' => 'news.full',
			'label'      => 'Toàn quyền',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'news.editowner',
			'label'      => 'Chỉ sửa tin tự đăng',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'news.create',
			'label'      => 'Tạo tin mới',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'news.edit',
			'label'      => 'Sửa tin',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'news.editpublish',
			'label'      => 'Sửa tin đã xuất bản',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'news.delete',
			'label'      => 'Xóa tin',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'news.review',
			'label'      => 'Xét duyệt tin',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'news.publish',
			'label'      => 'Xuất bản tin',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'news.unpublish',
			'label'      => 'Gỡ tin đã xuất bản',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'news.createcategory',
			'label'      => 'Tạo chuyên mục',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'news.editcategory',
			'label'      => 'Sửa chuyên mục',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'news.deletecategory',
			'label'      => 'Xóa chuyên mục',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'news.createtag',
			'label'      => 'Tạo chủ đề',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'news.edittag',
			'label'      => 'Sửa chủ đề',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'news.deletetag',
			'label'      => 'Xóa chủ đề',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'news.edittopic',
			'label'      => 'Sửa luồng sự kiện',
			'type'      => 'sconf',
		),
	),
	'Bình luận' => array(
		array(
			'permission' => 'news.viewcomment',
			'label'      => 'Xem bình luận',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'news.editcomment',
			'label'      => 'Sửa bình luận',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'news.approvecomment',
			'label'      => 'Xét duyệt bình luận',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'news.deletecomment',
			'label'      => 'Xóa bình luận',
			'type'      => 'sconf',
		),
	),
	'Hoạt động bài viết' => array(
		array(
			'permission' => 'activities.overview',
			'label'      => 'Hoạt động chung',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'activities.post',
			'label'      => 'Tất cả bài viết',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'activities.ownpost',
			'label'      => 'Chỉ bài viết của mình',
			'type'      => 'sconf',
		),
	),
	'Nhuận bút' => array(
		array(
			'permission' => 'royalty.full',
			'label'      => 'Toàn quyền',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'royalty.view',
			'label'      => 'Xem',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'royalty.ownerview',
			'label'      => 'Chỉ xem được bài tự đăng',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'royalty.set',
			'label'      => 'Chấm nhuận bút',
			'type'      => 'sconf',
		),
	),
	'Thống kê' => array(
		array(
			'permission' => 'statistic.news',
			'label'      => 'Bài viết',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'statistic.royalty',
			'label'      => 'Nhuận bút',
			'type'      => 'sconf',
		),
	),
	'Trang thông tin' => array(
		array(
			'permission' => 'pages.full',
			'label'      => 'Toàn quyền',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'pages.create',
			'label'      => 'Tạo trang',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'pages.edit',
			'label'      => 'Sửa trang',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'pages.delete',
			'label'      => 'Xóa trang',
			'type'      => 'sconf',
		),
	),
	'Thư viện' => array(
		array(
			'permission' => 'medias.full',
			'label'      => 'Toàn quyền',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'medias.viewall',
			'label'      => 'Xem tất cả',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'medias.upload',
			'label'      => 'Tải tệp tin',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'medias.edit',
			'label'      => 'Sửa tệp tin',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'medias.delete',
			'label'      => 'Xóa tệp tin',
			'type'      => 'sconf',
		),
	),
	'Menu' => array(
		array(
			'permission' => 'menus.full',
			'label'      => 'Toàn quyền',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'menus.create',
			'label'      => 'Tạo menu',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'menus.edit',
			'label'      => 'Sửa menu',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'menus.delete',
			'label'      => 'Xóa menu',
			'type'      => 'sconf',
		),
	),
	'Thiết lập' => array(
		array(
			'permission' => 'settings.appearance',
			'label'      => 'Giao diện',
			'type'      => 'sconf',
		),
		array(
			'permission' => 'settings.config',
			'label'      => 'Cấu hình',
			'type'      => 'sconf',
		),
	)
);
