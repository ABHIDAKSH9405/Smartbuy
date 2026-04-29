namespace WindowsFormsAppFixIT
{
    partial class FormBannirUtilisateur
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
            this.label1 = new System.Windows.Forms.Label();
            this.buttonBannir = new System.Windows.Forms.Button();
            this.buttonFermer = new System.Windows.Forms.Button();
            this.listBoxCompte = new System.Windows.Forms.ListBox();
            this.textBoxCompte = new System.Windows.Forms.TextBox();
            this.SuspendLayout();
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Font = new System.Drawing.Font("Microsoft Sans Serif", 16.2F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label1.Location = new System.Drawing.Point(74, 98);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(218, 32);
            this.label1.TabIndex = 0;
            this.label1.Text = "Nom du Compte";
            // 
            // buttonBannir
            // 
            this.buttonBannir.AutoSize = true;
            this.buttonBannir.Font = new System.Drawing.Font("Microsoft Sans Serif", 16.2F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.buttonBannir.Location = new System.Drawing.Point(509, 111);
            this.buttonBannir.Name = "buttonBannir";
            this.buttonBannir.Size = new System.Drawing.Size(235, 52);
            this.buttonBannir.TabIndex = 1;
            this.buttonBannir.Text = "Bannir";
            this.buttonBannir.UseVisualStyleBackColor = true;
            this.buttonBannir.Click += new System.EventHandler(this.buttonBannir_Click);
            // 
            // buttonFermer
            // 
            this.buttonFermer.AutoSize = true;
            this.buttonFermer.Font = new System.Drawing.Font("Microsoft Sans Serif", 16.2F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.buttonFermer.Location = new System.Drawing.Point(509, 203);
            this.buttonFermer.Name = "buttonFermer";
            this.buttonFermer.Size = new System.Drawing.Size(235, 52);
            this.buttonFermer.TabIndex = 3;
            this.buttonFermer.Text = "Fermer";
            this.buttonFermer.UseVisualStyleBackColor = true;
            this.buttonFermer.Click += new System.EventHandler(this.buttonFermer_Click);
            // 
            // listBoxCompte
            // 
            this.listBoxCompte.Font = new System.Drawing.Font("Microsoft Sans Serif", 16.2F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.listBoxCompte.FormattingEnabled = true;
            this.listBoxCompte.ItemHeight = 31;
            this.listBoxCompte.Location = new System.Drawing.Point(81, 135);
            this.listBoxCompte.Name = "listBoxCompte";
            this.listBoxCompte.Size = new System.Drawing.Size(210, 252);
            this.listBoxCompte.TabIndex = 4;
            this.listBoxCompte.SelectedIndexChanged += new System.EventHandler(this.listBoxCompte_SelectedIndexChanged);
            // 
            // textBoxCompte
            // 
            this.textBoxCompte.Font = new System.Drawing.Font("Microsoft Sans Serif", 16.2F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.textBoxCompte.Location = new System.Drawing.Point(336, 135);
            this.textBoxCompte.Name = "textBoxCompte";
            this.textBoxCompte.Size = new System.Drawing.Size(120, 38);
            this.textBoxCompte.TabIndex = 5;
            this.textBoxCompte.TextChanged += new System.EventHandler(this.textBox1_TextChanged);
            // 
            // FormBannirUtilisateur
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(8F, 16F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(800, 450);
            this.Controls.Add(this.textBoxCompte);
            this.Controls.Add(this.listBoxCompte);
            this.Controls.Add(this.buttonFermer);
            this.Controls.Add(this.buttonBannir);
            this.Controls.Add(this.label1);
            this.Name = "FormBannirUtilisateur";
            this.Text = "Form2";
            this.Load += new System.EventHandler(this.FormBannirUtilisateur_Load);
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.Button buttonBannir;
        private System.Windows.Forms.Button buttonFermer;
        private System.Windows.Forms.ListBox listBoxCompte;
        private System.Windows.Forms.TextBox textBoxCompte;
    }
}