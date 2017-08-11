<?php

namespace App\Admin\Controllers;

use App\ApiLog;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Routing\Controller;

class ApiLogController extends Controller
{
    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('Permission API Log');
            $content->description(trans('admin::lang.list'));

            $grid = Admin::grid(ApiLog::class, function (Grid $grid) {
                $grid->model()->orderBy('id', 'DESC');

                $grid->id('ID')->sortable();
                $grid->username()->sortable();
                $grid->path()->label('info');
                $grid->ip()->label('primary')->sortable();
                $grid->response()->value(function ($input) {
                    $input = json_decode($input, true);

                    return '<code>' . json_encode($input, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . '</code>';
                });

                $grid->created_at(trans('admin::lang.created_at'));

                $grid->actions(function (Grid\Displayers\Actions $actions) {
                    $actions->disableEdit();
                });

                $grid->disableCreation();

                $grid->filter(function ($filter) {
                    $filter->is('username', 'Username')->select(ApiLog::distinct('username')->pluck('username', 'username'));
                    $filter->is('permission', 'Permission')->select(ApiLog::distinct('permission')->pluck('permission', 'permission'));
                    $filter->like('path');
                    $filter->is('ip');

                    $filter->useModal();
                });
            });

            $content->body($grid);
        });
    }

    public function destroy($id)
    {
        $ids = explode(',', $id);

        if (ApiLog::destroy(array_filter($ids))) {
            return response()->json([
                'status' => true,
                'message' => trans('admin::lang.delete_succeeded'),
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => trans('admin::lang.delete_failed'),
            ]);
        }
    }
}
