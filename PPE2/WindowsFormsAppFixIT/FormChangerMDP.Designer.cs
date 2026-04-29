namespace WindowsFormsAppFixIT
{
    partial class FormChangerMDP
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
            this.Nom = new System.Windows.Forms.Label();
            this.buttonModifier = new System.Windows.Forms.Button();
            this.textBoxNom = new System.Windows.Forms.TextBox();
            this.textBoxAncienMDP = new System.Windows.Forms.TextBox();
            this.label1 = new System.Windows.Forms.Label();
            this.textBoxNouveauMDP = new System.Windows.Forms.TextBox();
            this.NouveauMDP = new System.Windows.Forms.Label();
            this.buttonFermer = new System.Windows.Forms.Button();
            this.SuspendLayout();
            // 
            // Nom
            // 
            this.Nom.AutoSize = true;
            this.Nom.Font = new System.Drawing.Font("Microsoft Sans Serif", 16.2F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.Nom.Location = new System.Drawing.Point(164, 58);
            this.Nom.Name = "Nom";
            this.Nom.Size = new System.Drawing.Size(73, 32);
            this.Nom.TabIndex = 0;
            this.Nom.Text = "Nom";
            // 
            // buttonModifier
            // 
            this.buttonModifier.Font = new System.Drawing.Font("Microsoft Sans Serif", 16.2F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.buttonModifier.Location = new System.Drawing.Point(500, 146);
            this.buttonModifier.Name = "buttonModifier";
            this.buttonModifier.Size = new System.Drawing.Size(179, 48);
            this.buttonModifier.TabIndex = 1;
            this.buttonModifier.Text = "Modifier";
            this.buttonModifier.UseVisualStyleBackColor = true;
            this.buttonModifier.Click += new System.EventHandler(this.buttonModifier_Click);
            // 
            // textBoxNom
            // 
            this.textBoxNom.Font = new System.Drawing.Font("Microsoft Sans Serif", 16.2F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.textBoxNom.Location = new System.Drawing.Point(160, 91);
            this.textBoxNom.Name = "textBoxNom";
            this.textBoxNom.Size = new System.Drawing.Size(161, 38);
            this.textBoxNom.TabIndex = 2;
            // 
            // textBoxAncienMDP
            // 
            this.textBoxAncienMDP.Font = new System.Drawing.Font("Microsoft Sans Serif", 16.2F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.textBoxAncienMDP.Location = new System.Drawing.Point(160, 190);
            this.textBoxAncienMDP.Name = "textBoxAncienMDP";
            this.textBoxAncienMDP.Size = new System.Drawing.Size(161, 38);
            this.textBoxAncienMDP.TabIndex = 4;
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Font = new System.Drawing.Font("Microsoft Sans Serif", 16.2F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label1.Location = new System.Drawing.Point(164, 155);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(278, 32);
            this.label1.TabIndex = 3;
            this.label1.Text = "Ancien Mot de passe";
            // 
            // textBoxNouveauMDP
            // 
            this.textBoxNouveauMDP.Font = new System.Drawing.Font("Microsoft Sans Serif", 16.2F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.textBoxNouveauMDP.Location = new System.Drawing.Point(160, 287);
            this.textBoxNouveauMDP.Name = "textBoxNouveauMDP";
            this.textBoxNouveauMDP.Size = new System.Drawing.Size(161, 38);
            this.textBoxNouveauMDP.TabIndex = 6;
            // 
            // NouveauMDP
            // 
            this.NouveauMDP.AutoSize = true;
            this.NouveauMDP.Font = new System.Drawing.Font("Microsoft Sans Serif", 16.2F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.NouveauMDP.Location = new System.Drawing.Point(164, 254);
            this.NouveauMDP.Name = "NouveauMDP";
            this.NouveauMDP.Size = new System.Drawing.Size(304, 32);
            this.NouveauMDP.TabIndex = 5;
            this.NouveauMDP.Text = "Nouveau Mot de passe";
            // 
            // buttonFermer
            // 
            this.buttonFermer.Font = new System.Drawing.Font("Microsoft Sans Serif", 16.2F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.buttonFermer.Location = new System.Drawing.Point(500, 254);
            this.buttonFermer.Name = "buttonFermer";
            this.buttonFermer.Size = new System.Drawing.Size(179, 48);
            this.buttonFermer.TabIndex = 7;
            this.buttonFermer.Text = "Fermer";
            this.buttonFermer.UseVisualStyleBackColor = true;
            this.buttonFermer.Click += new System.EventHandler(this.buttonFermer_Click);
            // 
            // FormChangerMDP
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(8F, 16F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(800, 450);
            this.Controls.Add(this.buttonFermer);
            this.Controls.Add(this.textBoxNouveauMDP);
            this.Controls.Add(this.NouveauMDP);
            this.Controls.Add(this.textBoxAncienMDP);
            this.Controls.Add(this.label1);
            this.Controls.Add(this.textBoxNom);
            this.Controls.Add(this.buttonModifier);
            this.Controls.Add(this.Nom);
            this.Name = "FormChangerMDP";
            this.Text = "Form2";
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.Label Nom;
        private System.Windows.Forms.Button buttonModifier;
        private System.Windows.Forms.TextBox textBoxNom;
        private System.Windows.Forms.TextBox textBoxAncienMDP;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.TextBox textBoxNouveauMDP;
        private System.Windows.Forms.Label NouveauMDP;
        private System.Windows.Forms.Button buttonFermer;
    }
}