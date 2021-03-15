<section class="content-header">
    <h1>Categories
        <small>Goods Catagories</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
        <li class="active">categories</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <i class="icon fa fa-check"></i><?=$this->session->flashdata('success');?>
    </div>

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Category Database</h3>
            <div class="pull-right">
                <a href="<?=site_url('category/add')?>" class="btn btn-primary btn-flat">
                    <i class="fa fa-plus-square"></i> Create
                </a>
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="table1">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach($row->result() as $key => $data) { ?>
                    <tr>
                        <td style="width:5%;"><?=$no++?>.</td>
                        <td><?=$data->name?></td>

                        <td class="text-center" width="160px">
                            <a href="<?=site_url('category/edit/'.$data->category_id)?>" class="btn btn-primary btn-xs">
                                <i class="fa fa-pencil"></i> Update
                            </a>
                            <a href="<?=site_url('category/del/'.$data->category_id)?>"
                                onclick="return confirm('are you sure want to delete')" class="btn btn-danger btn-xs">
                                <i class="fa fa-trash"></i> Delete
                            </a>
                            </form>
                        </td>
                    </tr>
                    <?php
                    } ?>
                </tbody>
            </table>
        </div>
    </div>

</section>