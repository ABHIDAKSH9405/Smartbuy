namespace WindowsFormsAppFixIT
{
    partial class FormCategorie
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            this.listBoxCategorie = new System.Windows.Forms.ListBox();
            this.textBoxCategorie = new System.Windows.Forms.TextBox();
            this.label1 = new System.Windows.Forms.Label();
            this.buttonAdd = new System.Windows.Forms.Button();
            this.buttonModifier = new System.Windows.Forms.Button();
            this.buttonDel = new System.Windows.Forms.Button();
            this.buttonClose = new System.Windows.Forms.Button();
            this.pictureBoxCategorie = new System.Windows.Forms.PictureBox();
            this.buttonPhoto = new System.Windows.Forms.Button();
            this.buttonModifierPhoto = new System.Windows.Forms.Button();
            this.buttonSupprimerPhoto = new System.Windows.Forms.Button();
            ((System.ComponentModel.ISupportInitialize)(this.pictureBoxCategorie)).BeginInit();
            this.SuspendLayout();
            //
            // listBoxCategorie
            //
            this.listBoxCategorie.Font = new System.Drawing.Font("Microsoft Sans Serif", 13.8F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.listBoxCategorie.FormattingEnabled = true;
            this.listBoxCategorie.ItemHeight = 29;
            this.listBoxCategorie.Location = new System.Drawing.Point(12, 12);
            this.listBoxCategorie.Name = "listBoxCategorie";
            this.listBoxCategorie.Size = new System.Drawing.Size(202, 336);
            this.listBoxCategorie.TabIndex = 0;
            this.listBoxCategorie.SelectedIndexChanged += new System.EventHandler(this.listBoxCategorie_SelectedIndexChanged);
            //
            // label1
            //
            this.label1.AutoSize = true;
            this.label1.Font = new System.Drawing.Font("Microsoft Sans Serif", 13.8F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label1.Location = new System.Drawing.Point(228, 12);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(65, 29);
            this.label1.TabIndex = 2;
            this.label1.Text = "Nom";
            //
            // textBoxCategorie
            //
            this.textBoxCategorie.Font = new System.Drawing.Font("Microsoft Sans Serif", 13.8F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.textBoxCategorie.Location = new System.Drawing.Point(228, 48);
            this.textBoxCategorie.Name = "textBoxCategorie";
            this.textBoxCategorie.Size = new System.Drawing.Size(155, 34);
            this.textBoxCategorie.TabIndex = 1;
            //
            // pictureBoxCategorie
            //
            this.pictureBoxCategorie.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.pictureBoxCategorie.Location = new System.Drawing.Point(228, 100);
            this.pictureBoxCategorie.Name = "pictureBoxCategorie";
            this.pictureBoxCategorie.Size = new System.Drawing.Size(130, 130);
            this.pictureBoxCategorie.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom;
            this.pictureBoxCategorie.TabIndex = 7;
            this.pictureBoxCategorie.TabStop = false;
            //
            // buttonPhoto
            //
            this.buttonPhoto.Font = new System.Drawing.Font("Microsoft Sans Serif", 10F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.buttonPhoto.Location = new System.Drawing.Point(228, 238);
            this.buttonPhoto.Name = "buttonPhoto";
            this.buttonPhoto.Size = new System.Drawing.Size(155, 35);
            this.buttonPhoto.TabIndex = 8;
            this.buttonPhoto.Text = "Ajouter une photo";
            this.buttonPhoto.UseVisualStyleBackColor = true;
            this.buttonPhoto.Click += new System.EventHandler(this.buttonPhoto_Click);
            //
            // buttonModifierPhoto
            //
            this.buttonModifierPhoto.Font = new System.Drawing.Font("Microsoft Sans Serif", 10F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.buttonModifierPhoto.Location = new System.Drawing.Point(228, 279);
            this.buttonModifierPhoto.Name = "buttonModifierPhoto";
            this.buttonModifierPhoto.Size = new System.Drawing.Size(155, 35);
            this.buttonModifierPhoto.TabIndex = 9;
            this.buttonModifierPhoto.Text = "Modifier la photo";
            this.buttonModifierPhoto.UseVisualStyleBackColor = true;
            this.buttonModifierPhoto.Click += new System.EventHandler(this.buttonModifierPhoto_Click);
            //
            // buttonSupprimerPhoto
            //
            this.buttonSupprimerPhoto.Font = new System.Drawing.Font("Microsoft Sans Serif", 10F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.buttonSupprimerPhoto.Location = new System.Drawing.Point(228, 320);
            this.buttonSupprimerPhoto.Name = "buttonSupprimerPhoto";
            this.buttonSupprimerPhoto.Size = new System.Drawing.Size(155, 35);
            this.buttonSupprimerPhoto.TabIndex = 10;
            this.buttonSupprimerPhoto.Text = "Supprimer la photo";
            this.buttonSupprimerPhoto.UseVisualStyleBackColor = true;
            this.buttonSupprimerPhoto.Click += new System.EventHandler(this.buttonSupprimerPhoto_Click);
            //
            // buttonAdd
            //
            this.buttonAdd.Font = new System.Drawing.Font("Microsoft Sans Serif", 13.8F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.buttonAdd.Location = new System.Drawing.Point(405, 12);
            this.buttonAdd.Name = "buttonAdd";
            this.buttonAdd.Size = new System.Drawing.Size(168, 54);
            this.buttonAdd.TabIndex = 3;
            this.buttonAdd.Text = "Ajouter";
            this.buttonAdd.UseVisualStyleBackColor = true;
            this.buttonAdd.Click += new System.EventHandler(this.buttonAdd_Click);
            //
            // buttonModifier
            //
            this.buttonModifier.Font = new System.Drawing.Font("Microsoft Sans Serif", 13.8F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.buttonModifier.Location = new System.Drawing.Point(405, 74);
            this.buttonModifier.Name = "buttonModifier";
            this.buttonModifier.Size = new System.Drawing.Size(168, 54);
            this.buttonModifier.TabIndex = 4;
            this.buttonModifier.Text = "Modifier";
            this.buttonModifier.UseVisualStyleBackColor = true;
            this.buttonModifier.Click += new System.EventHandler(this.buttonModifier_Click);
            //
            // buttonDel
            //
            this.buttonDel.Font = new System.Drawing.Font("Microsoft Sans Serif", 13.8F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.buttonDel.Location = new System.Drawing.Point(405, 136);
            this.buttonDel.Name = "buttonDel";
            this.buttonDel.Size = new System.Drawing.Size(168, 54);
            this.buttonDel.TabIndex = 5;
            this.buttonDel.Text = "Supprimer";
            this.buttonDel.UseVisualStyleBackColor = true;
            this.buttonDel.Click += new System.EventHandler(this.buttonSupprimer_Click);
            //
            // buttonClose
            //
            this.buttonClose.DialogResult = System.Windows.Forms.DialogResult.Cancel;
            this.buttonClose.Font = new System.Drawing.Font("Microsoft Sans Serif", 13.8F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.buttonClose.Location = new System.Drawing.Point(405, 295);
            this.buttonClose.Name = "buttonClose";
            this.buttonClose.Size = new System.Drawing.Size(168, 54);
            this.buttonClose.TabIndex = 6;
            this.buttonClose.Text = "Fermer";
            this.buttonClose.UseVisualStyleBackColor = true;
            this.buttonClose.Click += new System.EventHandler(this.buttonClose_Click);
            //
            // FormCategorie
            //
            this.AutoScaleDimensions = new System.Drawing.SizeF(8F, 16F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.CancelButton = this.buttonClose;
            this.ClientSize = new System.Drawing.Size(590, 364);
            this.Controls.Add(this.buttonSupprimerPhoto);
            this.Controls.Add(this.buttonModifierPhoto);
            this.Controls.Add(this.buttonPhoto);
            this.Controls.Add(this.pictureBoxCategorie);
            this.Controls.Add(this.buttonClose);
            this.Controls.Add(this.buttonDel);
            this.Controls.Add(this.buttonModifier);
            this.Controls.Add(this.buttonAdd);
            this.Controls.Add(this.label1);
            this.Controls.Add(this.textBoxCategorie);
            this.Controls.Add(this.listBoxCategorie);
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.Fixed3D;
            this.MaximizeBox = false;
            this.MinimizeBox = false;
            this.Name = "FormCategorie";
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterParent;
            this.Text = "Categorie";
            this.Load += new System.EventHandler(this.FormCategorie_Load);
            ((System.ComponentModel.ISupportInitialize)(this.pictureBoxCategorie)).EndInit();
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.ListBox listBoxCategorie;
        private System.Windows.Forms.TextBox textBoxCategorie;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.Button buttonAdd;
        private System.Windows.Forms.Button buttonModifier;
        private System.Windows.Forms.Button buttonDel;
        private System.Windows.Forms.Button buttonClose;
        private System.Windows.Forms.PictureBox pictureBoxCategorie;
        private System.Windows.Forms.Button buttonPhoto;
        private System.Windows.Forms.Button buttonModifierPhoto;
        private System.Windows.Forms.Button buttonSupprimerPhoto;
    }
}
